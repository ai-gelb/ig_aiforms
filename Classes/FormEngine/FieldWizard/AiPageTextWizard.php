<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Igelb\IgAiforms\Service\LanguageService;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AiPageTextWizard extends AbstractNode
{
    public function render(): array
    {

        $pageUid = $this->data['databaseRow']['uid'];
        $hiddenField = $this->data['databaseRow']['hidden'];

        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonTitle');

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);

        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiText'];


        $aiToReadColumnsText = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonPageInfo');

        $resultData = $this->initializeResultArray();

        $language = LanguageService::getLanguage($this->data);

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsPageTextWizard.js');

        if ($hiddenField == 1) {
            $disabled = 'disabled';
        } else {
            $disabled = '';
        }
        $resultData['html'] = '<button '. $disabled .' title="' . $aiToReadColumnsText . '" class="btn btn-default igjs-form-page-text-ai" data-language="' . $language['locale'] . '" data-what-do-you-want="' . $fieldWizardConfig['IDoThisForYou'] . '" data-page-uid="' . $pageUid . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">' . $buttonTitle . ' ' . $icon . '</button>';

        return $resultData;
    }
}
