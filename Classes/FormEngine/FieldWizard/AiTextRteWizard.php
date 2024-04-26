<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Igelb\IgAiforms\Service\LanguageService;


class AiTextRteWizard extends AbstractNode
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

        foreach ($fieldWizardConfig['aiToRead'] as $keyAiToRead => $valueAiToRead) {
            $fieldWizardConfig['aiToRead'][$keyAiToRead] = 'data' . str_replace($this->data['fieldName'], $valueAiToRead, $this->data['elementBaseName']);
        }

        $fieldWizardConfig['aiToRead'] = implode(',', $fieldWizardConfig['aiToRead']);

        $language = LanguageService::getLanguage($this->data);

        $resultData = $this->initializeResultArray();

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsTextRteWizard.js');

        $resultData['html'] = '<button class="btn btn-default igjs-form-text-rte-ai" data-language="' . $language['locale'] . '" data-what-do-you-want="' . $fieldWizardConfig['IDoThisForYou'] . '" data-ai-to-read="' . $fieldWizardConfig['aiToRead'] . '"  data-ai-to-paste="' . $this->data['elementBaseName'] . '" type="button">' . $buttonTitle . ' ' . $icon . '</button>';

        return $resultData;
    }
}
