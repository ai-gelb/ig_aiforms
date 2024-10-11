<?php

namespace Igelb\IgAiforms\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AiController extends ActionController
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function giveMeATextAction(ServerRequestInterface $request): ResponseInterface
    {

        $apiKey = getenv('OPENAI_API_KEY');
        $url = 'https://api.openai.com/v1/chat/completions';

        // JSON aus dem Request Body extrahieren
        $content = $request->getBody()->getContents();
        $jsonData = json_decode($content, true);

        if (empty($apiKey)) {
            throw new \Exception('OPENAI_API_KEY is not set');
        }

        $ch = curl_init($url);

        // cURL Optionen setzen
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));

        // Anfrage ausführen
        $response = curl_exec($ch);

        // Fehlerprüfung
        if (curl_errno($ch)) {
            echo 'cURL-Fehler: ' . curl_error($ch);
        }

        // cURL-Session beenden
        curl_close($ch);

        return $this->jsonResponse($response);
    }
}
