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
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ArrayUtility;

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

        /* @var \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        if ($this->signalSlotDispatcher == null)
            $this->signalSlotDispatcher = $objectManager->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

        // 2013-04-22	kraftb@webconsulting.at
        // Check if the tt_news "displaySingle" method has been called before
        if (class_exists('tx_jhopengraphttnews_displaySingleHook'))
        {
            $hookObject = GeneralUtility::makeInstance('tx_jhopengraphttnews_displaySingleHook');
            if ($hookObject->singleViewDisplayed())
                return $content;
        }
        if (class_exists(\Heilmann\JhOpengraphTtnews\Hooks\DisplaySingle::class))
        {
            $hookObject = GeneralUtility::makeInstance(\Heilmann\JhOpengraphTtnews\Hooks\DisplaySingle::class);
            if ($hookObject->singleViewDisplayed())
                return $content;
        }

        //if there has been no return, get og properties and render output

        // Get title
        $og['title'] = htmlspecialchars(!empty($GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtitle']) ?
            $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtitle'] :
            $GLOBALS['TSFE']->page['title']);

        // Get type
        $og['type'] = htmlspecialchars(!empty($GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtype']) ?
            $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtype'] :
            $conf['type']);

        // Get images
        /** @var FileRepository $fileRepository */
        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);

        $fileObjects = array();
        if ($GLOBALS['TSFE']->page['_PAGES_OVERLAY_UID'])
        {
            // Get images if there is a language overlay
            // This is somehow a hack, as l10n_mode 'mergeIfNotBlack' does not work in this case.
            // PageRepository->shouldFieldBeOverlaid does not work for config type 'inline' with "DEFAULT '0'" database config,
            // as an empty inline field is '0', and '0' is treated as not empty.
            // Setting 'Default NULL' in database config won't work, too, as it isn't easier to check, if value in
            // $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogtype'] is related to table 'pages' or 'pages_language_overlay'.

            $overlayFileObjects = $fileRepository->findByRelation('pages_language_overlay', 'tx_jhopengraphprotocol_ogfalimages', $GLOBALS['TSFE']->page['_PAGES_OVERLAY_UID']);
            if (count($overlayFileObjects) > 0)
                $fileObjects = $overlayFileObjects;
            else if (isset($GLOBALS['TCA']['pages_language_overlay']['columns']['tx_jhopengraphprotocol_ogfalimages']['l10n_mode']) &&
                $GLOBALS['TCA']['pages_language_overlay']['columns']['tx_jhopengraphprotocol_ogfalimages']['l10n_mode'] === 'mergeIfNotBlank')
                $fileObjects = $fileRepository->findByRelation('pages', 'tx_jhopengraphprotocol_ogfalimages', $GLOBALS['TSFE']->id);
        } else
            $fileObjects = $fileRepository->findByRelation('pages', 'tx_jhopengraphprotocol_ogfalimages', $GLOBALS['TSFE']->id);

        if (count($fileObjects) === 0)
        {
            // check if an image is given in page --> media, if not use default image
            $fileObjects = $fileRepository->findByRelation(
                ($GLOBALS['TSFE']->page['_PAGES_OVERLAY_UID'] ? 'pages_language_overlay' : 'pages'),
                'media',
                ($GLOBALS['TSFE']->page['_PAGES_OVERLAY_UID'] ?:$GLOBALS['TSFE']->id)
            );
            if (count($fileObjects) === 0)
            {
                $imageFileName = $GLOBALS['TSFE']->tmpl->getFileName($conf['image']);
                if (!empty($imageFileName))
                    $og['image'][] = $imageFileName;
            } else
                $og['image'] = $fileObjects;
        } else
            $og['image'] = $fileObjects;

        // Get url
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj */
        $cObj = $objectManager->get(\TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::class);
        $additionalParams = GeneralUtility::_GET();
        if (GeneralUtility::_GP('L'))
            $additionalParams['L'] = (int)GeneralUtility::_GP('L');
        unset($additionalParams['id']);
        $lConf = [
            'additionalParams' => '&' . GeneralUtility::implodeArrayForUrl('', $additionalParams),
            'forceAbsoluteUrl' => '1',
            'parameter' => $GLOBALS['TSFE']->id
        ];
        $og['url'] = htmlentities($cObj->typoLink_URL($lConf));


        // Get site_name
        $og['site_name'] = htmlspecialchars(!empty($conf['sitename']) ?
            $conf['sitename'] :
            $GLOBALS['TSFE']->tmpl->setup['sitetitle']);

        // Get description
        if (!empty($GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogdescription']))
            $og['description'] = $GLOBALS['TSFE']->page['tx_jhopengraphprotocol_ogdescription'];
        else
            $og['description'] = !empty($GLOBALS['TSFE']->page['description']) ?
                $GLOBALS['TSFE']->page['description'] :
                $conf['description'];

        $og['description'] = htmlspecialchars($og['description']);

        // Get locale
        $localeParts = explode('.', $GLOBALS['TSFE']->tmpl->setup['config.']['locale_all']);
        if (isset($localeParts[0]))
            $og['locale'] = str_replace('-', '_', $localeParts[0]);

        // Signal to manipulate og-properties before header creation
        // Please do not use the second parameter ($this->cObj) in your dispatcher, but $GLOBALS['TSFE']->page instead.
        // This allows you to use the advantage of easy multilingual page handling.
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
                            // Render each value to a new og property meta-tag
                            $res[] = $key == 'image' ?
                                $this->buildOgImageProperties($key, $multiPropertyValue) :
                                $this->buildProperty($key, $multiPropertyValue);
                    } else
                        // A og property with child-properties
                        $res .= $this->renderHeaderLines($this->remapArray($key, $value));
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
            $res[] = $this->buildProperty($key, GeneralUtility::locationHeaderUrl($value->getPublicUrl()));
            if ($value->getMimeType())
                $res[] = $this->buildProperty($key . ':type', $value->getMimeType());
            if ($value->getProperty('width'))
                $res[] = $this->buildProperty($key . ':width', $value->getProperty('width'));
            if ($value->getProperty('height'))
                $res[] = $this->buildProperty($key . ':height', $value->getProperty('height'));
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
