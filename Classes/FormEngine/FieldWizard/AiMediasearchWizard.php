<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Igelb\IgAiforms\Service\LanguageService;

class AiMediasearchWizard extends AbstractNode
{
    public function render(): array
    {
        // Get the language service and the button title
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonTitle');

        // Get the icon for the button
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);

        // Get the field wizard configuration in TCA
        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiText'];

        // Get the text for the button
        $aiToReadColumnsText = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonInfo');

        $resultData = $this->initializeResultArray();

        $language = LanguageService::getLanguage($this->data);

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsTextWizard.js');

        $html = [];

        $html[] = '<button';
        $html[] = '    title="' . $aiToReadColumnsText . '"';
        $html[] = '    class="btn btn-default igjs-form-text-ai"';
        $html[] = '    data-language="' . $language['locale'] . '"';
        $html[] = '    data-what-do-you-want="' . $fieldWizardConfig['iDoThisForYou'] . '"';
        $html[] = '    data-ai-to-paste="data' . $this->data['elementBaseName'] . '"';
        $html[] = '    type="button">';
        $html[] = $buttonTitle . ' ' . $icon;
        $html[] = '</button>';

        $resultData['html'] = implode(' ', $html);

        return $resultData;
    }
}
