<?php

return [
    'igelb_ig_aiforms_ai' => [
        'path' => '/aiforms/giveMeAText',
        'target' => Igelb\IgAiforms\Controller\AiController::class . '::giveMeATextAction',
    ],
    'igelb_ig_aiforms_file' => [
        'path' => '/aiforms/file',
        'target' => Igelb\IgAiforms\Controller\FileController::class . '::getFileBase64Action',
    ],
    'igelb_ig_aiforms_page' => [
        'path' => '/aiforms/page',
        'target' => Igelb\IgAiforms\Controller\PageController::class . '::getPageAction',
    ],
];
