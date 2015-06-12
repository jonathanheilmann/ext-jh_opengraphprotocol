<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2014 Jonathan Heilmann <mail@jonathan-heilmann.de>
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

/**
* @author    Jonathan Heilmann <mail@jonathan-heilmann.de>
* @package    TYPO3
* @subpackage    tx_jhopengraphprotocol2
*/
class tx_jhopengraphprotocol_service_ogrenderer {

	/**
	 * content Object
	 */
	var $cObj;

	/**
	 * Main-function to render the Open Grapg protocol content.
	 *
	 * @param	string	$content
	 * @param	array		$conf
	 * @return	string
	 */
	public function main($content, $conf){
		$extKey = 'tx_jhopengraphprotocol';
		$content = '';
		$og = array();

		// 2013-04-22	kraftb@webconsulting.at
		// Check if the tt_news "displaySingle" method has been called before
		if(class_exists('tx_jhopengraphttnews_displaySingleHook')) {
			$hookObject = t3lib_div::makeInstance('tx_jhopengraphttnews_displaySingleHook');
			if ($hookObject->singleViewDisplayed()) {
				return $content;
			}
		}

		//if there has been no return, get og properties and render output

		// Get title
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogtitle'])) {
			$og['title'] = $this->cObj->data['tx_jhopengraphprotocol_ogtitle'];
		} else {
			$og['title'] = $GLOBALS['TSFE']->page['title'];
		}
		$og['title'] = htmlentities($og['title']);

		// Get type
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogtype'])) {
			$og['type'] = $this->cObj->data['tx_jhopengraphprotocol_ogtype'];
		} else {
			$og['type'] = $conf['type'];
		}
		$og['type'] = htmlentities($og['type']);

		// Get image
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogimage'])) {
			$images = explode(',', $this->cObj->data['tx_jhopengraphprotocol_ogimage']);
			foreach ($images as $key => $image) {
				$og['image'][$key] = t3lib_div::locationHeaderUrl($GLOBALS['TSFE']->tmpl->getFileName('uploads/tx_jhopengraphprotocol/' . $image));
			}
		} else {
			$fileName = $GLOBALS['TSFE']->tmpl->getFileName($conf['image']);
			$og['image'] = (!empty($fileName)) ? t3lib_div::locationHeaderUrl($fileName) : $og['image'] = '';
		}

		// Get url
		$og['url'] = htmlentities(t3lib_div::getIndpEnv('TYPO3_REQUEST_URL'));

		// Get site_name
		if (!empty($conf['sitename'])) {
			$og['site_name'] = $conf['sitename'];
		} else {
			$og['site_name'] = $GLOBALS['TSFE']->tmpl->setup['sitetitle'];
		}
		$og['site_name'] = htmlentities($og['site_name']);

		// Get description
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogdescription'])) {
			$og['description'] = $this->cObj->data['tx_jhopengraphprotocol_ogdescription'];
		} else {
			if (!empty($GLOBALS['TSFE']->page['description'])) {
				$og['description'] = $GLOBALS['TSFE']->page['description'];
			} else {
				$og['description'] = $conf['description'];
			}
		}
		$og['description'] = htmlentities($og['description']);

		// Get locale
		$og['locale'] = $GLOBALS['TSFE']->tmpl->setup['config.']['locale_all'];

		//add tags to html-header
		$GLOBALS['TSFE']->additionalHeaderData[$extKey] = $this->renderHeaderLines($og);

		return $content;
	}

	/**
	 * Render the header lines to be added from array
	 *
	 * @param	array		$array
	 * @return	string
	 */
	private function renderHeaderLines($array) {
		$res = '';
		foreach ($array as $key => $value) {
			if (!empty($value )) { // Skip empty values to prevent from empty og property
				if (is_array($value)) {
					// A op property with multiple values or child-properties
					if(array_key_exists('0', $value)) {
						// A og property that accepts more than one value
						foreach ($value as $multiPropertyValue) {
							// Render each value to a new og property meta-tag
							$res .= '<meta property="og:'.$key.'" content="'.$multiPropertyValue.'" />';
						}
					} else {
						// A og property with child-properties
						$res .= $this->renderHeaderLines($this->remapArray($key, $value));
					}
				} else {
					// A singe og property to be rendered
					$res .= '<meta property="og:'.$key.'" content="'.$value.'" />';
				}
			}
		}
		return $res;
	}

	/**
	 * Remap an array: Add $prefixKey to keys of $array
	 *
	 * @param	string	$prefixKey
	 * @param	array		$array
	 * @return	array
	 */
	private function remapArray($prefixKey, $array) {
		$res = array();
		foreach ($array as $key => $value) {
			$res[$prefixKey.':'.$key] = $value;
		}

		return $res;
	}
}
?>