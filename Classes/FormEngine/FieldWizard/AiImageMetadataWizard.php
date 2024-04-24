<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Beuser\Domain\Model\Demand;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use Igelb\IgAiforms\Service\FileService;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AiImageMetadataWizard extends AbstractNode
{

    public function render(): array
    {

        $resultData = $this->initializeResultArray();

        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiImageMetadata'];

        $file = FileService::getFilesWithoutMetadata($this->data['databaseRow']['uid']);

        $storage = FileService::getFileStorage($file['storage']);

        if (empty($file)) {
            return $resultData;
        }

        if ($fieldWizardConfig['aiPublicFile'] ?? false == true) {

            $fileUrl = $fieldWizardConfig['aiPublicFileUrl'] . "/" . $storage . $file['identifier'];


        } else {

            //b64encode the file
            $fileUrl = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $storage . $file['identifier']));


        }

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsImageWizard.js');

        $resultData['html'] = '<div class="form-control"><button class="btn btn-default igjs-form-ai" data-what-do-you-want="' . $fieldWizardConfig['aiWhatDoYouWant'] . '" data-file-public="' . ($fieldWizardConfig['aiPublicFile'] == true ? "1" : "0") . '" data-file-url="' . $fileUrl . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">Generieren mit AI</button></div>';

        return $resultData;
    }
}
