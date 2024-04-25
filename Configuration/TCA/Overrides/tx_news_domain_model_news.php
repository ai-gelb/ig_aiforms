<?php

defined('TYPO3') || exit();

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext',
    'aiWhatDoYouWant' => 'I give you a Teaser from  this News. Maximal 150 letters.'
];

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextRteWizard',
    'aiToRead' => 'title',
    'aiWhatDoYouWant' => 'I give you a bodytext from  this News title.'
];
