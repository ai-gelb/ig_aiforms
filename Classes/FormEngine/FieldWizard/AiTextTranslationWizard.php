<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Igelb\IgAiforms\Service\LanguageService;

class AiTextTranslationWizard extends AbstractNode
{
    public function render(): array
    {
        // Get the language service and the button Text
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiTextTranslation.buttonTitle');

        // Get the icon for the button
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        // Get all languages
        $allLanguages = LanguageService::getAllLanguages();

        // Get the field wizard configuration in TCA
        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiTextTranslation'];

        // Prepare the result data
        $resultData = $this->initializeResultArray();

        // Get the language and the default language row
        if ($this->data['defaultLanguageRow'] != null) {
            $fieldWizardConfig['aiToRead'] = 'data' . str_replace($this->data['fieldName'], $this->data['fieldName'] . 'LLL', $this->data['elementBaseName']);
            $value = str_replace("'", '"', $this->data['defaultLanguageRow'][$this->data['fieldName']]);

            // Prepare the HTML and the hidden input field for the default language row
            $html = [];
            $html[] = '<input';
            $html[] = ' type="hidden"';
            $html[] = ' name="' . $fieldWizardConfig['aiToRead'] . '"';
            $html[] = ' value=\'' . $value . '\'';
            $html[] = ' />';

            // Prepare the HTML for the buttons for the other languages
            if ($allLanguages) {
                foreach ($allLanguages as $key => $value) {
                    $icon = $iconFactory->getIcon($value['flag'], ICON::SIZE_SMALL);
                    $html[] = '<button';
                    $html[] = ' class="btn btn-default igjs-form-text-translation-ai"';
                    $html[] = ' data-icon="' . $value['flag'] . '"';
                    $html[] = ' data-language="' . $value['locale'] . '"';
                    $html[] = ' data-what-do-you-want="' . $fieldWizardConfig['iDoThisForYou'] . '"';
                    $html[] = ' data-ai-to-read="' . $fieldWizardConfig['aiToRead'] . '"';
                    $html[] = ' data-ai-to-paste="data' . $this->data['elementBaseName'] . '"';
                    $html[] = ' type="button">';
                    $html[] = $buttonTitle . ' ' . $icon;
                    $html[] = '</button>';
                }
            }

            $resultData['html'] = implode(' ', $html);
        }

        // Add the JavaScript module
        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsTextTranslationWizard.js');

        // Return the result data
        return $resultData;
    }
}
