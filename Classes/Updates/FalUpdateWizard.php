<?php
namespace Heilmann\JhOpengraphprotocol\Updates;

/***************************************************************
*  Copyright notice
*
*  (c) 2015-2016 Jonathan Heilmann <mail@jonathan-heilmann.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
* @author    Jonathan Heilmann <mail@jonathan-heilmann.de>
* @package    tx_jhopengraphprotocol
*/
class FalUpdateWizard extends \TYPO3\CMS\Install\Updates\AbstractUpdate
{

    const FOLDER_ContentUploads = '_migrated/tx_jhopengraphprotocol_uploads';
    
    const CruserId = 777;

    /**
     * @var string
     */
    protected $title = 'Migrate file relations of EXT:jh_opengraphprotocol';

    /**
     * @var string
     */
    protected $targetDirectory;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    protected $fileFactory;

    /**
     * @var \TYPO3\CMS\Core\Resource\FileRepository
     */
    protected $fileRepository;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceStorage
     */
    protected $storage;

    /**
     * Initialize all required repository and factory objects.
     *
     * @throws \RuntimeException
     */
    protected function init()
    {
        $fileadminDirectory = rtrim($GLOBALS['TYPO3_CONF_VARS']['BE']['fileadminDir'], '/') . '/';
        /** @var $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
        $storageRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
        $storages = $storageRepository->findAll();
        foreach ($storages as $storage) {
            $storageRecord = $storage->getStorageRecord();
            $configuration = $storage->getConfiguration();
            $isLocalDriver = $storageRecord['driver'] === 'Local';
            $isOnFileadmin = !empty($configuration['basePath']) && GeneralUtility::isFirstPartOfStr($configuration['basePath'], $fileadminDirectory);
            if ($isLocalDriver && $isOnFileadmin) {
                $this->storage = $storage;
                break;
            }
        }
        if (!isset($this->storage)) {
            throw new \RuntimeException('Local default storage could not be initialized - might be due to missing sys_file* tables.');
        }
        $this->fileFactory = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
        $this->fileRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
        $this->targetDirectory = PATH_site . $fileadminDirectory . self::FOLDER_ContentUploads . '/';
    }

    /**
     * Checks if an update is needed
     *
     * @param string &$description : The description for the update
     * @return boolean TRUE if an update is needed, FALSE otherwise
     */
    public function checkForUpdate(&$description)
    {
        $updateNeeded = false;
        // Fetch records where the old relation is used and the new one is empty
        $notMigratedMediaRowsCount = $GLOBALS['TYPO3_DB']->exec_SELECTcountRows(
            'pages.uid',
            'pages',
            'pages.tx_jhopengraphprotocol_ogimage <> \'\' AND tx_jhopengraphprotocol_ogfalimages = 0'
        );
        if ($notMigratedMediaRowsCount > 0) {
            $description = 'There are <strong>' . $notMigratedMediaRowsCount . '</strong> page records which are using the old media relation. '
                . 'This wizard will move the files to "fileadmin/' . self::FOLDER_ContentUploads . '".';
            $updateNeeded = true;
        }

        return $updateNeeded;
    }

    /**
     * Performs the database update.
     *
     * @param array &$dbQueries Queries done in this update
     * @param mixed &$customMessages Custom messages
     * @return boolean TRUE on success, FALSE on error
     */
    public function performUpdate(array &$dbQueries, &$customMessages)
    {
        $this->init();
        $this->checkPrerequisites();

        $records = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            '*',
            'pages',
            'pages.tx_jhopengraphprotocol_ogimage <> \'\' AND tx_jhopengraphprotocol_ogfalimages = 0'
        );
        if ($records) {
            foreach ($records as $record) {
                $this->migrateFiles($record, 'tx_jhopengraphprotocol_ogfalimages');
            }
            $this->setCountInPagesRecord('tx_jhopengraphprotocol_ogfalimages');
        }

        return true;
    }

    /**
     * Update the pages table and set the count of relations
     *
     * @param string $field
     * @return void
     */
    protected function setCountInPagesRecord($field)
    {
        $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            'count(*) as count, uid_foreign as uid',
            'sys_file_reference',
            'deleted=0 AND hidden=0 AND
				cruser_id=' . self::CruserId . ' AND fieldname= "' . $field . '" AND tablenames= "pages"',
            'uid_foreign'
        );

        foreach ($rows as $row) {
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                'pages',
                $field . '= 0 AND uid=' . (int)$row['uid'],
                array($field => $row['count'])
            );
        }
    }

    /**
     * Ensures a new folder "fileadmin/_migrated/tx_jhopengraphprotocol_uploads" is available.
     *
     * @return void
     */
    protected function checkPrerequisites()
    {
        if (!$this->storage->hasFolder(self::FOLDER_ContentUploads)) {
            $this->storage->createFolder(self::FOLDER_ContentUploads, $this->storage->getRootLevelFolder());
        }
    }

    /**
     * Migrate files to sys_file_references
     *
     * @param array $record
     * @param string $field
     * @return void
     */
    protected function migrateFiles(array $record, $field)
    {
        $filesList = $record['tx_jhopengraphprotocol_ogimage'];
        $files = GeneralUtility::trimExplode(',', $filesList, true);
        
        if ($files) {
            foreach ($files as $file) {
                if (file_exists(PATH_site . 'uploads/tx_jhopengraphprotocol/' . $file)) {
                    GeneralUtility::upload_copy_move(
                            PATH_site . 'uploads/tx_jhopengraphprotocol/' . $file,
                            $this->targetDirectory . $file);
                
                    $fileObject = $this->storage->getFile(self::FOLDER_ContentUploads . '/' . $file);
                    $this->fileRepository->add($fileObject);
                    $dataArray = array(
                            'uid_local' => $fileObject->getUid(),
                            'tablenames' => 'pages',
                            'fieldname' => $field,
                            'uid_foreign' => $record['uid'],
                            'table_local' => 'sys_file',
                            // the sys_file_reference record should always placed on the same page
                            // as the record to link to, see issue #46497
                            'cruser_id' => self::CruserId,
                            'pid' => $record['pid'],
                            'sorting_foreign' => $record['sorting'],
                            'title' => $record['title'],
                    );
                
                    $GLOBALS['TYPO3_DB']->exec_INSERTquery('sys_file_reference', $dataArray);
                }
            }
        }
    }
}
