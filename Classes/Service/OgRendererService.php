<?php
namespace Heilmann\JhOpengraphprotocol\Service;

/***************************************************************
*  Copyright notice
*
*  (c) 2014-2016 Jonathan Heilmann <mail@jonathan-heilmann.de>
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

use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Class OgRendererService
 * @package Heilmann\JhOpengraphprotocol\Service
 */
class OgRendererService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * content Object
     *
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    public $cObj;

    /**
     * SignalSlotDispatcher
     *
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     * @inject
     */
    protected $signalSlotDispatcher;

    /**
     * Main-function to render the Open Graph protocol content.
     *
     * @param	string	$content
     * @param	array		$conf
     * @return	string
     */
    public function main($content, $conf)
    {
        $extKey = 'tx_jhopengraphprotocol';
        $content = '';
        $og = array();

        if ($this->signalSlotDispatcher == null) {
            /* @var \TYPO3\CMS\Extbase\Object\ObjectManager */
            $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $this->signalSlotDispatcher = $objectManager->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
        }

        // 2013-04-22	kraftb@webconsulting.at
        // Check if the tt_news "displaySingle" method has been called before
        if (class_exists('tx_jhopengraphttnews_displaySingleHook')) {
            $hookObject = GeneralUtility::makeInstance('tx_jhopengraphttnews_displaySingleHook');
            if ($hookObject->singleViewDisplayed())
                return $content;
        }
        if (class_exists(\Heilmann\JhOpengraphTtnews\Hooks\DisplaySingle::class)) {
            $hookObject = GeneralUtility::makeInstance(\Heilmann\JhOpengraphTtnews\Hooks\DisplaySingle::class);
            if ($hookObject->singleViewDisplayed())
                return $content;
        }

        //if there has been no return, get og properties and render output

        // Get title
        if (!empty($GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtitle'])) {
            $og['title'] = $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtitle'];
        } else {
            $og['title'] = $GLOBALS['TSFE']->page['title'];
        }
        $og['title'] = htmlspecialchars($og['title']);

        // Get type
        if (!empty($GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtype'])) {
            $og['type'] = $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtype'];
        } else {
            $og['type'] = $conf['type'];
        }
        $og['type'] = htmlspecialchars($og['type']);

		$fileRelationPid = $GLOBALS['TSFE']->page['_PAGES_OVERLAY_UID'] ?: $GLOBALS['TSFE']->id;
		$fileRelationTable = $GLOBALS['TSFE']->page['_PAGES_OVERLAY_UID'] ? 'pages_language_overlay' : 'pages';

        // Get image
        /** @var \TYPO3\CMS\Core\Resource\FileRepository $fileRepository */
        $fileRepository = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
		$fileObjects = $fileRepository->findByRelation($fileRelationTable, 'tx_jhopengraphprotocol_ogfalimages', $fileRelationPid);
        if (count($fileObjects)) {
            foreach ($fileObjects as $key => $fileObject) {
                /** @var FileReference $fileObject */
                $og['image'][] = $fileObject;
            }
        } else {
            // check if an image is given in page --> media, if not use default image
            $fileObjects = $fileRepository->findByRelation($fileRelationTable, 'media', $fileRelationPid);
            if (count($fileObjects)) {
                foreach ($fileObjects as $key => $fileObject) {
                    /** @var FileReference $fileObject */
                    $og['image'][] = $fileObject;
                }
            } else {
                $imageFileName = $GLOBALS['TSFE']->tmpl->getFileName($conf['image']);
                if (!empty($imageFileName)) {
                    $og['image'][] = $imageFileName;
                }
            }
        }
        
        // Get url
        $og['url'] = htmlentities(GeneralUtility::getIndpEnv('TYPO3_REQUEST_URL'));

        // Get site_name
        if (!empty($conf['sitename'])) {
            $og['site_name'] = $conf['sitename'];
        } else {
            $og['site_name'] = $GLOBALS['TSFE']->tmpl->setup['sitetitle'];
        }
        $og['site_name'] = htmlspecialchars($og['site_name']);

        // Get description
        if (!empty($GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogdescription'])) {
            $og['description'] = $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogdescription'];
        } else {
            if (!empty($GLOBALS['TSFE']->page['description'])) {
                $og['description'] = $GLOBALS['TSFE']->page['description'];
            } else {
                $og['description'] = $conf['description'];
            }
        }
        $og['description'] = htmlspecialchars($og['description']);

        // Get locale
        $localeParts = explode('.', $GLOBALS['TSFE']->tmpl->setup['config.']['locale_all']);
        if (isset($localeParts[0])) {
            $og['locale'] = str_replace('-', '_', $localeParts[0]);
        }

        // Signal to manipulate og-properties before header creation
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            'beforeHeaderCreation',
            array(&$og, $this->cObj)
        );

        //add tags to html-header
        $GLOBALS['TSFE']->additionalHeaderData[$extKey] = $this->renderHeaderLines($og);

        return $content;
    }

    /**
     * Renders the header lines to be added from array
     *
     * @param	array		$array
     * @return	string
     */
    protected function renderHeaderLines($array)
    {
        $res = array();
        foreach ($array as $key => $value)
        {
            if (!empty($value))
            {
                // Skip empty values to prevent from empty og property
                if (is_array($value))
                {
                    // A op property with multiple values or child-properties
                    if (array_key_exists('0', $value))
                    {
                        // A og property that accepts more than one value
                        foreach ($value as $multiPropertyValue)
                        {
                            // Render each value to a new og property meta-tag
                            if ($key == 'image')
                            {
                                // Add image details
                                $res[] = $this->buildOgImageProperties($key, $multiPropertyValue);
                            } else
                            {
                                $res[] = $this->buildProperty($key, $multiPropertyValue);
                            }
                        }
                    } else
                    {
                        // A og property with child-properties
                        $res .= $this->renderHeaderLines($this->remapArray($key, $value));
                    }
                } else
                {
                    // A single og property to be rendered
                    $res[] = $this->buildProperty($key, $value);
                }
            }
        }
        return implode(chr(10), ArrayUtility::flatten($res));
    }

    /**
     * Builds open graph properties for images
     *
     * @param string $key
     * @param mixed $value
     * @return array
     */
    protected function buildOgImageProperties($key, $value)
    {
        $res = array();

        if (is_object($value) && $value instanceOf FileReference)
        {
            /** @var FileReference $value */
            $res[] = $this->buildProperty($key,
                GeneralUtility::locationHeaderUrl($value->getPublicUrl()));
            $res[] = $this->buildProperty($key . ':type', $value->getMimeType());
            $res[] = $this->buildProperty($key . ':width',
                $value->getProperty('width'));
            $res[] = $this->buildProperty($key . ':height',
                $value->getProperty('height'));
        } else if (is_string($value))
        {
            $imageSize = array();
            $parsedUrl = parse_url($value);
            if (isset($parsedUrl['host']) && $parsedUrl['host'])
            {
                // Analyze image with given host
                $res[] = $this->buildProperty($key, $value);

                if (GeneralUtility::getHostname() == $parsedUrl['host'])
                {
                    // Get image absolute filename on own host
                    $value = GeneralUtility::getFileAbsFileName(
                        substr($parsedUrl['path'], 1) .
                        (isset($parsedUrl['query']) && $parsedUrl['query'] ? '?' . $parsedUrl['query'] : '') .
                        (isset($parsedUrl['fragment']) && $parsedUrl['fragment'] ? '#' . $parsedUrl['fragment'] : '')
                    );
                }

                if (file_exists($value))
                    $imageSize = getimagesize($value);
            } else
            {
                // Analyze image with relative filename
                $absImagePath = GeneralUtility::getFileAbsFileName($value);
                if (file_exists($absImagePath))
                {
                    $imageSize = getimagesize($absImagePath);

                    $res[] = $this->buildProperty($key,
                        GeneralUtility::locationHeaderUrl($value));
                }
            }

            // Add image details if available
            if (isset($imageSize['mime']) && $imageSize['mime'])
                $res[] = $this->buildProperty($key . ':type', $imageSize['mime']);
            if (isset($imageSize[0]) && $imageSize[0])
                $res[] = $this->buildProperty($key . ':width', $imageSize[0]);
            if (isset($imageSize[1]) && $imageSize[1])
                $res[] = $this->buildProperty($key . ':height', $imageSize[1]);
        }

        return $res;
    }

    /**
     * Build meta property tag
     *
     * @param   string  $key
     * @param   string  $value
     * @return  string
     */
    protected function buildProperty($key, $value)
    {
        return '<meta property="og:' . $key . '" content="' . $value . '" />';
    }

    /**
     * Remap an array: Add $prefixKey to keys of $array
     *
     * @param	string	$prefixKey
     * @param	array		$array
     * @return	array
     */
    protected function remapArray($prefixKey, $array)
    {
        $res = array();
        foreach ($array as $key => $value)
            $res[$prefixKey.':'.$key] = $value;

        return $res;
    }
}
