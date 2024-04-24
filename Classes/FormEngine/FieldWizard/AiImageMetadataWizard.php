<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use Igelb\IgAiforms\Service\FileService;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AiImageMetadataWizard extends AbstractNode
{
    public function render(): array
    {
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);

        $resultData = $this->initializeResultArray();

        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiImageMetadata'];

        $file = FileService::getFilesWithoutMetadata($this->data['databaseRow']['uid']);

        $storage = FileService::getFileStorage($file['storage']);

        if (empty($file)) {
            return $resultData;
        }

        if ($fieldWizardConfig['aiPublicFile'] ?? false == true) {
            $fileUrl = $fieldWizardConfig['aiPublicFileUrl'] . '/' . $storage . $file['identifier'];
        } else {
            $fileUrl = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $storage . $file['identifier']));
        }

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsImageWizard.js');

        $resultData['html'] = '<div class="form-control"><button class="btn btn-default igjs-form-ai" data-what-do-you-want="' . $fieldWizardConfig['aiWhatDoYouWant'] . '" data-file-public="' . ($fieldWizardConfig['aiPublicFile'] == true ? '1' : '0') . '" data-file-url="' . $fileUrl . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">Generieren mit AI ' . $icon . '</button></div>';

        return $resultData;
    }
}
