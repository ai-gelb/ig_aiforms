<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use Igelb\IgAiforms\Service\LanguageService;
use Igelb\IgAiforms\Service\FileService;
use Igelb\IgSite\Domain\Model\File;
use TYPO3\CMS\Beuser\Domain\Model\Demand;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AiImageMetadataWizard extends AbstractNode
{
    public function render(): array
    {
        $languageService = GeneralUtility::makeInstance(LanguageServiceFactory::class)->createFromUserPreferences($GLOBALS['BE_USER']);
        $buttonTitle = $languageService->sL('LLL:EXT:ig_aiforms/Resources/Private/Language/locallang.xlf:fieldWizard.aiText.buttonTitle');

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);

        $resultData = $this->initializeResultArray();

        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiImageMetadata'];

        $file = $this->data['databaseRow']['uid'];

        $fileExtension = FileService::getFileExtension($file);

        if (!in_array($fileExtension, $fieldWizardConfig['fileExtension'])) {
            return $resultData;
        }

        $language = LanguageService::getLanguage($this->data);

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsImageWizard.js');

        $resultData['html'] = '<div class="form-control"><button class="btn btn-default igjs-form-ai" data-language="' . $language['locale'] . '" data-what-do-you-want="' . $fieldWizardConfig['IDoThisForYou'] . '" data-file="' . $file . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">' . $buttonTitle . ' ' . $icon . '</button></div>';

        return $resultData;
    }
}
