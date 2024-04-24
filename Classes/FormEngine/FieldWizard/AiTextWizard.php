<?php

namespace Igelb\IgAiforms\FormEngine\FieldWizard;

use TYPO3\CMS\Backend\Form\AbstractNode;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * 'fieldWizard' => [
 * 'aiText' => [
 *   'renderType' => 'aiShortTextWizard',
 *   'aiToRead' => 'title,long_text',
 *   'aiWhatDoYouWant' => 'Gib mir ein verkürzter Text mit maximal 150 Zeichen, Bitte auf Deutsch. Bitte keine Anführungszeichen davor oder danach machen.'
 *  ]
 * ]
 */
class AiTextWizard extends AbstractNode
{
    public function render(): array
    {
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIcon('actions-infinity', ICON::SIZE_SMALL);
        //DebuggerUtility::var_dump($this->data);
        $fieldWizardConfig = $this->data['processedTca']['columns'][$this->data['fieldName']]['config']['fieldWizard']['aiText'];

        //explode $fieldWizardConfig['aiToRead'] and delete empty values and spaces in array
        $fieldWizardConfig['aiToRead'] = explode(',', $fieldWizardConfig['aiToRead']);
        $fieldWizardConfig['aiToRead'] = array_map('trim', $fieldWizardConfig['aiToRead']);
        $fieldWizardConfig['aiToRead'] = array_filter($fieldWizardConfig['aiToRead']);

        //replace $fieldWizardConfig['aiToRead'] with dataFieldName
        foreach ($fieldWizardConfig['aiToRead'] as $keyAiToRead => $valueAiToRead) {
            $fieldWizardConfig['aiToRead'][$keyAiToRead] = 'data' . str_replace($this->data['fieldName'], $valueAiToRead, $this->data['elementBaseName']);
        }
        //implode $fieldWizardConfig['aiToRead'] to string
        $fieldWizardConfig['aiToRead'] = implode(',', $fieldWizardConfig['aiToRead']);

        //DebuggerUtility::var_dump($this->data);
        //DebuggerUtility::var_dump($fieldWizardConfig['aiToRead']);

        $resultData = $this->initializeResultArray();

        $resultData['javaScriptModules'][] = JavaScriptModuleInstruction::create('@igelb/ig-aiforms/AiFormsTextWizard.js');

        $resultData['html'] = '<div class="form-control"><button class="btn btn-default igjs-form-text-ai" data-what-do-you-want="' . $fieldWizardConfig['aiWhatDoYouWant'] . '" data-ai-to-read="' . $fieldWizardConfig['aiToRead'] . '"  data-ai-to-paste="data' . $this->data['elementBaseName'] . '" type="button">Generieren mit AI ' . $icon . '</button></div>';

        return $resultData;
    }
}
