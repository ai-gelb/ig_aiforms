<?php

return [
    // required import configurations of other extensions,
    // in case a module imports from another package
    'dependencies' => ['backend'],
    'tags' => [
        'backend.form',
    ],
    // import-mapping of JavaScript files
    'imports' => [
        '@igelb/ig-aiforms/AiFormsTextWizard.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/AiFormsTextWizard.js',
        '@igelb/ig-aiforms/AiFormsTextRteWizard.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/AiFormsTextRteWizard.js',
        '@igelb/ig-aiforms/AiFormsImageWizard.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/AiFormsImageWizard.js',
        '@igelb/ig-aiforms/FetchAi.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/FetchAi.js',
        '@igelb/ig-aiforms/FetchFile.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/FetchFile.js',
        '@igelb/ig-aiforms/AiFormsTextTranslationRteWizard.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/AiFormsTextTranslationRteWizard.js',
        '@igelb/ig-aiforms/AiFormsTextTranslationWizard.js' => 'EXT:ig_aiforms/Resources/Public/JavaScript/AiFormsTextTranslationWizard.js',
    ],
];
