<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Igelb\IgAiforms\Service\LanguageService;

class AiImageMetadataWizard extends AbstractNode
{
    public function render(): array
    {
        // Get the language service and the button Text
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonTitle');

        // Get the icon for the button
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);

        // Prepare the result data
        $resultData = $this->initializeResultArray();

        // Get the field wizard configuration in TCA
        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiImageMetadata'];

        // Get the file uid
        $file = $this->data['databaseRow']['uid'];

        // Get the language
        $language = LanguageService::getLanguage($this->data);

        // Add the JavaScript module
        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsImageWizard.js');

        // Prepare the HTML
        $html = [];
        $html[] = '<button';
        $html[] = ' title="' . $buttonTitle . '"';
        $html[] = ' class="btn btn-default igjs-form-ai"';
        $html[] = ' data-language="' . $language['locale'] . '"';
        $html[] = ' data-what-do-you-want="' . $fieldWizardConfig['IDoThisForYou'] . '"';
        $html[] = ' data-file="' . $file . '"';
        $html[] = ' data-ai-to-paste="data' . $this->data['elementBaseName'] . '"';
        $html[] = ' type="button"';
        $html[] = '>';
        $html[] = $buttonTitle . ' ' . $icon;
        $html[] = '</button>';

        $resultData['html'] = implode(' ', $html);

        // Return the result data
        return $resultData;
    }
}
