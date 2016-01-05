<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$TYPO3_CONF_VARS['FE']['pageOverlayFields'] .= ',tx_jhopengraphprotocol_ogtitle,tx_jhopengraphprotocol_ogtype,tx_jhopengraphprotocol_ogfalimages,tx_jhopengraphprotocol_ogdescription';

// Add update script to install tool
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['jh_opengraphprotocol_fal'] = 'Heilmann\\JhOpengraphprotocol\\Updates\\FalUpdateWizard';
