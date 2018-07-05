<?php
if (!defined('TYPO3_MODE'))
    die('Access denied.');

// Add static file
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Open Graph protocol');
