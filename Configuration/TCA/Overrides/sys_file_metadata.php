<?php

defined('TYPO3') || exit();

$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'IDoThisForYou' => 'I give you an alternativ Text for this Image. I Show You what I see.  Maximal 100 letters.',
    'aiPublicFile' => false,
];

$GLOBALS['TCA']['sys_file_metadata']['columns']['description']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'IDoThisForYou' => 'I give you an description Text for this Image. Maximal 200 letters.',
    'aiPublicFile' => false
];
