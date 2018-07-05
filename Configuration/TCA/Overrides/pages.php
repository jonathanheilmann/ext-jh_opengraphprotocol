<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$_EXTKEY = 'jh_opengraphprotocol';

$tempColumns = array(
    'tx_jhopengraphprotocol_ogtitle' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogtitle',
        'config' => array(
            'type' => 'input',
            'size' => '160',
        )
    ),
    'tx_jhopengraphprotocol_ogtype' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogtype',
        'config' => array(
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_jhopengraphprotocol_ogimage' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogimage',
        'config' => array(
            'type' => 'group',
            'internal_type' => 'file',
            'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
            'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
            'uploadfolder' => 'uploads/tx_jhopengraphprotocol',
            'show_thumbs' => 1,
            'size' => 4,
            'minitems' => 0,
            'maxitems' => 6,
        )
    ),
    'tx_jhopengraphprotocol_ogfalimages' => array(
        'exclude' => 1,
        'label'    => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogimage',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'tx_jhopengraphprotocol_ogfalimages',
            array(
                'appearance' => array(
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,

                    'enableControls' => array(
                        'sort' => true,
                    ),
                ),
                'behaviour' => array(
                    'localizationMode' => 'select',
                    'localizeChildrenAtParentLocalization' => TRUE,
                ),
                'foreign_types' => array(
                    '0' => array(
                        'showitem' => '
						--palette--;;opengraphprotocolPalette,
						--palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                        'showitem' => '
						--palette--;;opengraphprotocolPalette,
						--palette--;;filePalette'
                    ),
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION  => array(
                        'showitem' => '
						--palette--;;opengraphprotocolPalette,
						--palette--;;filePalette'
                    ),
                ),
            ),
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        )
    ),
    'tx_jhopengraphprotocol_ogdescription' => array(
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogdescription',
        'config' => array(
            'type' => 'text',
            'size' => '30',
            'rows' => '3',
            'max' => '300',
        )
    ),
);

// Add columns to TCA of pages
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $tempColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', '--div--;LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tab_title,tx_jhopengraphprotocol_ogtitle;;;;1-1-1, tx_jhopengraphprotocol_ogtype, tx_jhopengraphprotocol_ogfalimages, tx_jhopengraphprotocol_ogdescription');
