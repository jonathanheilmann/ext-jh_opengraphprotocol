<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Create array with columns
$tempColumns = array (
    'tx_jhopengraphprotocol_ogtitle' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogtitle',
        'config' => array (
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_jhopengraphprotocol_ogtype' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogtype',
        'config' => array (
            'type' => 'input',
            'size' => '30',
        )
    ),
    'tx_jhopengraphprotocol_ogimage' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogimage',
        'config' => array (
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
    'tx_jhopengraphprotocol_ogdescription' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tx_jhopengraphprotocol_ogdescription',
        'config' => array (
            'type' => 'input',
            'size' => '30',
            'max' => '100',
        )
    ),
);

// Add columns to TCA of pages and pages_language_overlay
t3lib_extMgm::addTCAcolumns('pages',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('pages','--div--;LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tab_title,tx_jhopengraphprotocol_ogtitle;;;;1-1-1, tx_jhopengraphprotocol_ogtype, tx_jhopengraphprotocol_ogimage, tx_jhopengraphprotocol_ogdescription');

t3lib_extMgm::addTCAcolumns('pages_language_overlay',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('pages_language_overlay','--div--;LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:pages.tab_title,tx_jhopengraphprotocol_ogtitle;;;;1-1-1, tx_jhopengraphprotocol_ogtype, tx_jhopengraphprotocol_ogimage, tx_jhopengraphprotocol_ogdescription');

// Add static file
if (version_compare(TYPO3_branch, '6.0', '>=')) {
	// Add new static file for TYPO3 CMS >= 6.0
	t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Open Graph protocol');
}
if (version_compare(TYPO3_branch, '6.1', '<=')) {
	// Add old static file to stay compatible to TYPO3 CMS 4.5
	t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'Open Graph protocol v0.3.0');
}

?>