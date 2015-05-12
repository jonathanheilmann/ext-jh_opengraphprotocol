<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012-2014 Jonathan Heilmann <mail@jonathan-heilmann.de>
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
 * @subpackage    tx_jhopengraphprotocol
 */
class user_jhopengraphprotocol {

	/**
	 * content Object
	 */
	var $cObj;

	function main($content, $conf){
		$extKey = 'tx_jhopengraphprotocol';
		$content = '';

		// 2013-04-22	kraftb@webconsulting.at
		// Check if the tt_news "displaySingle" method has been called before
		if(class_exists('tx_jhopengraphttnews_displaySingleHook')) {
			$hookObject = t3lib_div::makeInstance('tx_jhopengraphttnews_displaySingleHook');
			if ($hookObject->singleViewDisplayed()) {
				return $content;
			}
		}

		//if there has been no return, render output

		//render title
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogtitle'])) {
			$title = $this->cObj->data['tx_jhopengraphprotocol_ogtitle'];
		} else {
			if (!empty($conf['title'])) {
			    $title = $conf['title'];
			} else {
			    $title = $GLOBALS['TSFE']->page['title'];
			}
		}
		$title = htmlentities($title);

		//render type
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogtype'])) {
			$type = $this->cObj->data['tx_jhopengraphprotocol_ogtype'];
		} else {
			$type = $conf['type'];
		}
		$type = htmlentities($type);

		//render image
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogimage'])) {
			$images = explode(',', $this->cObj->data['tx_jhopengraphprotocol_ogimage']);
			$image = $GLOBALS['TSFE']->tmpl->getFileName('uploads/tx_jhopengraphprotocol/' . $images[0]);// Since version 1.0.0: only render first image
		} else {
			$image = $GLOBALS['TSFE']->tmpl->getFileName($conf['image']);
		}

		//render link
		$link = htmlentities(t3lib_div::getIndpEnv('TYPO3_REQUEST_URL')); //now compatibel with CoolURI - thanks to thomas@chaschperli.ch

		//render sitename
		if (!empty($conf['sitename'])) {
			$sitename = $conf['sitename'];
		} else {
			$sitename = $GLOBALS['TSFE']->tmpl->setup['sitetitle'];
		}
		$sitename = htmlentities($sitename);

		//render description
		if (!empty($this->cObj->data['tx_jhopengraphprotocol_ogdescription'])) {
			$description = $this->cObj->data['tx_jhopengraphprotocol_ogdescription'];
		} else {
			//2013-12-29	http://www.shentao.de/
			//use description of page if available
			if (!empty($GLOBALS['TSFE']->page['description'])) {
				$description = $GLOBALS['TSFE']->page['description'];
			} else {
				$description = $conf['description'];
			}
		}
		$description = htmlentities($description);

		//render output to html-header
		if ($title != '') {$GLOBALS['TSFE']->additionalHeaderData[$extKey.'1'] = '<meta property="og:title" content="'.$title.'" />';}
		if ($type != '') {$GLOBALS['TSFE']->additionalHeaderData[$extKey.'2'] = '<meta property="og:type" content="'.$type.'" />';}
		if ($image != '') {$GLOBALS['TSFE']->additionalHeaderData[$extKey.'3'] = '<meta property="og:image" content="'.t3lib_div::locationHeaderUrl($image).'" />';}
		if ($link != '') {$GLOBALS['TSFE']->additionalHeaderData[$extKey.'4'] = '<meta property="og:url" content="'.$link.'" />';}
		if ($sitename != '') {$GLOBALS['TSFE']->additionalHeaderData[$extKey.'5'] = '<meta property="og:site_name" content="'.$sitename.'" />';}
		if ($description != '') {$GLOBALS['TSFE']->additionalHeaderData[$extKey.'6'] = '<meta property="og:description" content="'.$description.'" />';}

		return $content;
	}
}
?>