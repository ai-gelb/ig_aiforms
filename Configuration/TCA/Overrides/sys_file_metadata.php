<?php

defined('TYPO3') || exit();

// $GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
//     'renderType' => 'aiImageMetadataWizard',
//     'iDoThisForYou' => 'I give you an alternativ Text for this Image. I Show You what I see.  Maximal 100 letters.'
// ];

$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'iDoThisForYou' => 'I provide a functional, objective description of the provided image in no more than around 30 words so that someone who could not see it would be able to imagine it. If possible, follow an “object-action-context” framework: The object is the main focus. The action describes what’s happening, usually what the object is doing. The context describes the surrounding environment.
    If there is text found in the image, it is very important that you transcribe all of it, even if it extends the word count beyond 30 words.
    If there is no text found in the image, then there is no need to mention it.
    I should not begin the description with any variation of “The image”.'
];

$GLOBALS['TCA']['sys_file_metadata']['columns']['description']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'iDoThisForYou' => 'I give you an description Text for this Image. Maximal 200 letters.'
];
