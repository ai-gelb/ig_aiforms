<?php

namespace Igelb\IgAiforms\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Igelb\IgAiforms\Service\FileService;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Smalot\PdfParser\Parser;

class FileController extends ActionController
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getFileBase64Action(ServerRequestInterface $request): ResponseInterface
    {
        $content = $request->getBody()->getContents();

        $file = FileService::getFile($content);


        // if the file is enpty
        if (empty($file)) {
            $responseData = [
                'status' => 'error',
                'message' => 'File not found'
            ];

            $responseData = json_encode($responseData);

            return $this->jsonResponse($responseData);
        }


        $storage = FileService::getFileStorage($file['storage']);

        if($file['file_extension'] === 'pdf') {
            $fileBase64 = '';
            $parser = new Parser();
            $pdf = $parser->parseFile($_SERVER['DOCUMENT_ROOT'] . '/' . $storage . $file['identifier']);
            $fileText = $pdf->getText();
        } else {
            $fileText = '';
            $fileBase64 = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $storage . $file['identifier']));
        }

        $responseData = [
            'status' => 'ok',
            'extension' => $file['file_extension'],
            'base64' => $fileBase64,
            'text' => $fileText
        ];

        $responseData = json_encode($responseData);

        return $this->jsonResponse($responseData);
    }
}
