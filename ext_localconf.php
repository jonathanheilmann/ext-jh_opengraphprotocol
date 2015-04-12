<?php
if (!defined ('TYPO3_MODE')) {
     die ('Access denied.');
}

$TYPO3_CONF_VARS['FE']['pageOverlayFields'] .= ',tx_jhopengraphprotocol_ogtitle,tx_jhopengraphprotocol_ogtype,tx_jhopengraphprotocol_ogimage,tx_jhopengraphprotocol_ogdescription';

?>