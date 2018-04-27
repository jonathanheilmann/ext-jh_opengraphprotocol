<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Add new palette
$GLOBALS['TCA']['sys_file_reference']['palettes']['opengraphprotocolPalette'] = $GLOBALS['TCA']['sys_file_reference']['palettes']['basicoverlayPalette'];
$GLOBALS['TCA']['sys_file_reference']['palettes']['opengraphprotocolPalette']['showitem'] = '';