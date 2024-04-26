<?php

defined('TYPO3') || exit();

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext',
    'IDoThisForYou' => 'I give you a Teaser from  this News. Maximal 150 letters.'
];

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['config']['fieldWizard']['aiTextTranslation'] = [
    'renderType' => 'aiTextTranslationWizard',
    'IDoThisForYou' => 'I translate this Text.'
];





$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextRteWizard',
    'aiToRead' => 'title',
    'IDoThisForYou' => 'I give you a bodytext from  this News title.'
];

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config']['fieldWizard']['aiTextTranslation'] = [
    'renderType' => 'aiTextTranslationRteWizard',
    'IDoThisForYou' => 'I translate this Text.'
];


