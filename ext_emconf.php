<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "jh_opengraphprotocol".
 *
 * Auto generated 29-12-2013 12:55
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Open Graph protocol',
    'description' => 'Adds the Open Graph protocol properties in meta-tags to the html-header supporting multilingual-websites.',
    'category' => 'plugin',
    'shy' => 0,
    'version' => '1.2.5',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => 1,
    'lockType' => '',
    'author' => 'Jonathan Heilmann',
    'author_email' => 'mail@jonathan-heilmann.de',
    'author_company' => '',
    'CGLcompliance' => null,
    'CGLcompliance_note' => null,
    'constraints' =>
    array(
        'depends' =>
        array(
            'typo3' => '6.2.0-7.6.99',
        ),
        'conflicts' =>
        array(
            'jh_opengraph_ttnews' => '0.0.0-0.0.10',
        ),
        'suggests' =>
        array(
        ),
    ),
);
