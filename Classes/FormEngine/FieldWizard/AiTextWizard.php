<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Igelb\IgAiforms\Service\LanguageService;

class AiTextWizard extends AbstractNode
{
    public function render(): array
    {
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonTitle');

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);

        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiText'];

        $fieldWizardConfig['aiToRead'] = explode(',', $fieldWizardConfig['aiToRead']);
        $fieldWizardConfig['aiToRead'] = array_map('trim', $fieldWizardConfig['aiToRead']);
        $fieldWizardConfig['aiToRead'] = array_filter($fieldWizardConfig['aiToRead']);

        $aiToReadColumns = [];
        foreach ($fieldWizardConfig['aiToRead'] as $keyAiToRead => $valueAiToRead) {
            $fieldWizardConfig['aiToRead'][$keyAiToRead] = 'data' . str_replace($this->data['fieldName'], $valueAiToRead, $this->data['elementBaseName']);
            $aiToReadColumns[] = $this->data['processedTca']['columns'][$valueAiToRead]['label'];
        }

        $aiToReadColumnsText = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonInfo') . implode(', ', $aiToReadColumns);
        $fieldWizardConfig['aiToRead'] = implode(',', $fieldWizardConfig['aiToRead']);

        $resultData = $this->initializeResultArray();

        $language = LanguageService::getLanguage($this->data);

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsTextWizard.js');

        $resultData['html'] = '<button title="' . $aiToReadColumnsText . '" class="btn btn-default igjs-form-text-ai" data-language="' . $language['locale'] . '" data-what-do-you-want="' . $fieldWizardConfig['IDoThisForYou'] . '" data-ai-to-read="' . $fieldWizardConfig['aiToRead'] . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">' . $buttonTitle . ' ' . $icon . '</button>';

        return $resultData;
    }
}
