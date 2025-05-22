<?php

namespace Igelb\IgAiforms\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Igelb\IgAiforms\Service\FileService;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Smalot\PdfParser\Parser;

class PageController extends ActionController
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function getPageAction(ServerRequestInterface $request): ResponseInterface
    {
        $content = $request->getBody()->getContents();
        $pageUid = json_decode($content);

        // server get domain und set index.php?id=' . $pageUid;
        $domain = $_SERVER['HTTP_HOST'];
        $url = 'https://' . $domain . '/index.php?id=' . $pageUid;

        // get page content
        $pageContent = file_get_contents($url);

        $responseData = [
            'status' => 'ok',
            'content' => $pageContent
        ];

        $responseData = json_encode($responseData);

        return $this->jsonResponse($responseData);


    }
}
