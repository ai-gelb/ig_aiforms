<?php

defined('TYPO3') || exit();

$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'aiWhatDoYouWant' => 'Sage genau, was im Bild zu sehen ist. Ich benutze das für den alt der Datei. Bitte auf Deutsch. Bitte keine Anführungszeichen davor oder danach machen.',
    'aiPublicFile' => false,
];

$GLOBALS['TCA']['sys_file_metadata']['columns']['description']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'aiWhatDoYouWant' => 'Beschreibe dieses Bild, Maximal 60 Zeichen. Bitte auf Deutsch. Bitte keine Anführungszeichen davor oder danach machen.',
    'aiPublicFile' => false
];
