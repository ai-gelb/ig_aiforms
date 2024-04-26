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
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['keywords']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext',
    'IDoThisForYou' => 'I give you 5 keywords from  this News title and bodytext. Is separated by comma.'
];

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['description']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext',
    'IDoThisForYou' => 'I give you a description from  this News. Maximal 160 letters. this description is for SEO.'
];




$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextRteWizard',
    'aiToRead' => 'title',
    'IDoThisForYou' => 'I give you a bodytext from  this News title. Maximal 1000 letters. I must use <h2> and <h3> and <p> and <ul> and <ol> and <li> and <strong>',
];

$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config']['fieldWizard']['aiTextTranslation'] = [
    'renderType' => 'aiTextTranslationRteWizard',
    'IDoThisForYou' => 'I translate this Text.'
];


