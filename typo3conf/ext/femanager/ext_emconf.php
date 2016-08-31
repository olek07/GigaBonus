<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "femanager".
 *
 * Auto generated 30-08-2016 23:05
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'femanager',
  'description' => 'TYPO3 Frontend User Registration and Management based on
        Extbase and Fluid and on TYPO3 7.6 and the possibility to extend it.
        Extension basicly works like sr_feuser_register',
  'category' => 'plugin',
  'author' => 'femanager dev team',
  'author_email' => 'info@in2code.de',
  'author_company' => 'in2code.de - Wir leben TYPO3',
  'state' => 'stable',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'version' => '2.5.1',
  'constraints' => 
  array (
    'depends' => 
    array (
      'extbase' => '7.6.0-7.99.99',
      'fluid' => '7.6.0-7.99.99',
      'typo3' => '7.6.0-7.99.99',
      'php' => '5.5.0-7.99.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
      'sr_freecap' => '2.3.0-2.99.99',
      'static_info_tables' => '6.0.0-6.99.99',
    ),
  ),
  'clearcacheonload' => false,
);

