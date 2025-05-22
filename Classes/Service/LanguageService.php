<?php

declare(strict_types=1);

namespace Igelb\IgAiforms\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Site\SiteFinder;

class LanguageService
{
    /**
     *
     * @param array $data
     *
     * @return array
     */
    public static function getLanguage($data): array
    {
        if (empty($data['databaseRow']['sys_language_uid'])) {
            $data['databaseRow']['sys_language_uid'] = 0;
        }
        if ($data['databaseRow']['sys_language_uid'] === -1) {
            $data['databaseRow']['sys_language_uid'] = 0;
        }
        // SiteFinder Dienst instanziieren
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);

        // Alle Sites holen
        $sites = $siteFinder->getAllSites();

        // Durch alle Sites iterieren
        foreach ($sites as $site) {
            // Sprachkonfigurationen der Site holen
            $languages = $site->getLanguages();

            // Durch alle Sprachen iterieren
            foreach ($languages as $language) {
                // Prüfe, ob die Sprache Deutsch ist und hole die entsprechende Locale
                if ($language->getLanguageId() === $data['databaseRow']['sys_language_uid']) {
                    // Hier kannst du dann mit der deutschen Sprachkonfiguration arbeiten

                    return $language->toArray();
                }
            }
        }
    }

    /**
     *
     * @return array
     */
    public static function getAllLanguages(): array
    {
        // SiteFinder Dienst instanziieren
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);

        // Alle Sites holen
        $sites = $siteFinder->getAllSites();

        $languages = [];
        // Durch alle Sites iterieren
        foreach ($sites as $site) {
            // Sprachkonfigurationen der Site holen
            $languagesSite = $site->getLanguages();

            // Durch alle Sprachen iterieren
            foreach ($languagesSite as $language) {
                // Prüfe, ob die Sprache Deutsch ist und hole die entsprechende Locale
                $languages[] = $language->toArray();
            }
        }

        return $languages;
    }
}
