<?php

namespace Igelb\IgAiforms\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Igelb\IgAiforms\Service\FileService;

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
        $storage = FileService::getFileStorage($file['storage']);

        $fileBase64 = base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $storage . $file['identifier']));

        $responseData = [
            'base64' => $fileBase64
        ];

        $responseData = json_encode($responseData);

        return $this->jsonResponse($responseData);
    }
}
