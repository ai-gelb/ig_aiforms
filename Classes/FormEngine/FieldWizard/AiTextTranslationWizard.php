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
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiTextTranslation.buttonTitle');

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $allLanguages = LanguageService::getAllLanguages();

        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiTextTranslation'];

        $resultData = $this->initializeResultArray();

        if ($this->data['defaultLanguageRow'] != null) {
            $fieldWizardConfig['aiToRead'] = 'data' . str_replace($this->data['fieldName'], $this->data['fieldName'] . 'LLL', $this->data['elementBaseName']);
            $value = str_replace("'", '"', $this->data['defaultLanguageRow'][$this->data['fieldName']]);
            $resultData['html'] .= ' <input type="hidden" name="' . $fieldWizardConfig['aiToRead'] . '" value=\'' . $value . '\'  />';
            if ($allLanguages) {
                foreach ($allLanguages as $key => $value) {
                    $icon = $iconFactory->getIcon($value['flag'], ICON::SIZE_SMALL);
                    $resultData['html'] .= '<button class="btn btn-default igjs-form-text-translation-ai" data-icon="' . $value['flag'] . '" data-language="' . $value['locale'] . '" data-what-do-you-want="' . $fieldWizardConfig['IDoThisForYou'] . '" data-ai-to-read="' . $fieldWizardConfig['aiToRead'] . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">' . $buttonTitle . ' ' . $icon . '</button>';
                }
            }
        }

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsTextTranslationWizard.js');

        return $resultData;
    }
}
