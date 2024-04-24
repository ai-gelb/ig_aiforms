<?php

defined('TYPO3') || exit();

$GLOBALS['TCA']['pages']['columns']['title']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title',
    'aiWhatDoYouWant' => 'Schreib zwei Wörter'
];
