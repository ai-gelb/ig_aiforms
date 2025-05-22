# IG AIFORMS - KI-Integration für TYPO3

Diese TYPO3-Extension integriert KI-Funktionalitäten in das TYPO3-Backend und ermöglicht die Generierung und Übersetzung von Inhalten mit Hilfe von OpenAI.

## Funktionen

- KI-gestützte Textgenerierung für reguläre Felder
- KI-gestützte Textgenerierung für RTE-Felder (CKEditor)
- KI-gestützte Bildanalyse für Metadaten (Alt-Text, Beschreibungen)
- KI-gestützte Übersetzungen für reguläre Felder
- KI-gestützte Übersetzungen für RTE-Felder
- PDF-Analyse und Textextraktion mit KI

## Anforderungen

- TYPO3 12.x
- PHP 8.x
- OpenAI API-Schlüssel
- Erweiterung: smalot/pdfparser (wird automatisch via Composer installiert)

## Installation

### Via Composer

```bash
composer require igelb/ig-aiforms
```

Nach der Installation muss die Extension im TYPO3-Backend aktiviert werden.

## Konfiguration

### OpenAI API-Schlüssel

Um die KI-Funktionalitäten nutzen zu können, muss ein OpenAI API-Schlüssel konfiguriert werden. Setzen Sie dazu die folgende Umgebungsvariable:

```
OPENAI_API_KEY=sk-your-api-key-here
```

Dies kann in Ihrer `.env`-Datei, in den Server-Umgebungsvariablen oder in der TYPO3-Konfiguration erfolgen.

## Integration in andere Extensions

### Beispiel: Integration in eine bestehende TCA-Konfiguration

Um die KI-Funktionalitäten in eine bestehende TCA-Konfiguration zu integrieren, müssen Sie Ihre TCA-Overrides anpassen. Hier sind einige Beispiele:

#### Textgenerierung für ein reguläres Feld

```php
$GLOBALS['TCA']['your_table']['columns']['your_field']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext', // Felder, aus denen der KI-Inhalt generiert wird
    'iDoThisForYou' => 'Ich generiere einen Text basierend auf dem Titel und dem Haupttext. Maximal 250 Zeichen.'
];
```

#### Textgenerierung für ein RTE-Feld

```php
$GLOBALS['TCA']['your_table']['columns']['your_rte_field']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextRteWizard',
    'aiToRead' => 'title,teaser',
    'iDoThisForYou' => 'Ich generiere einen ausführlichen Text basierend auf dem Titel und dem Teaser. Ich verwende HTML-Tags wie <p>, <h2>, <h3>, <ul>, <li> und <strong>.'
];
```

#### Übersetzungswizard für ein reguläres Feld

```php
$GLOBALS['TCA']['your_table']['columns']['your_field']['config']['fieldWizard']['aiTextTranslation'] = [
    'renderType' => 'aiTextTranslationWizard',
    'iDoThisForYou' => 'Ich übersetze diesen Text.'
];
```

#### Bildanalyse für Metadaten

```php
$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'iDoThisForYou' => 'Ich erstelle einen Alt-Text für dieses Bild. Maximal 100 Zeichen.'
];
```

## Sicherheitshinweise

- Achten Sie darauf, dass Ihr OpenAI API-Schlüssel sicher gespeichert und nicht öffentlich zugänglich ist.
- Prüfen Sie die generierten Inhalte vor der Veröffentlichung auf Korrektheit und Angemessenheit.
- Beachten Sie die Datenschutzbestimmungen und informieren Sie Ihre Nutzer über den Einsatz von KI-Technologien.

## Anpassung der Prompts

Die Anweisungen für die KI können über die `iDoThisForYou`-Parameter in der TCA-Konfiguration angepasst werden. Hier können Sie detaillierte Anweisungen für die Generierung oder Übersetzung von Inhalten festlegen.

### Beispiele für verschiedene Anwendungsfälle:

#### Präzise Alt-Text-Generierung für Bilder
```php
$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'iDoThisForYou' => 'Ich erstelle einen kurzen, präzisen Alt-Text für dieses Bild. Der Text soll maximal 30 Wörter umfassen und folgt dem Muster "Objekt-Aktion-Kontext". Falls Text im Bild vorhanden ist, wird dieser vollständig transkribiert. Ich beginne nicht mit "Das Bild zeigt" oder ähnlichen Formulierungen.'
];
```

#### Umfangreiche Bildbeschreibung
```php
$GLOBALS['TCA']['sys_file_metadata']['columns']['description']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'iDoThisForYou' => 'Ich erstelle eine detaillierte Beschreibung dieses Bildes. Dabei berücksichtige ich Bildkomposition, Farben, Stimmung und dargestellte Objekte. Die Beschreibung soll etwa 150-200 Wörter umfassen und für SEO-Zwecke optimiert sein, mit relevanten Schlüsselwörtern.'
];
```

#### SEO-optimierte Metabeschreibung
```php
$GLOBALS['TCA']['pages']['columns']['description']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,subtitle,nav_title,content',
    'iDoThisForYou' => 'Ich erstelle eine SEO-optimierte Metabeschreibung für diese Seite. Die Beschreibung ist zwischen 140-160 Zeichen lang, enthält das wichtigste Keyword aus dem Seitentitel und endet mit einem klaren Call-to-Action. Die Beschreibung ist ansprechend formuliert und regt zum Klicken an.'
];
```

#### Automatische Inhaltszusammenfassung
```php
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'bodytext',
    'iDoThisForYou' => 'Ich fasse den Hauptinhalt in einem ansprechenden Teaser zusammen. Der Teaser ist maximal 250 Zeichen lang, weckt Neugier und enthält die wichtigsten Informationen aus dem Text. Ich verwende aktive Verben und eine direkte Ansprache.'
];
```

#### Keyword-Generierung für SEO
```php
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['keywords']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext',
    'iDoThisForYou' => 'Ich generiere 5-7 relevante Keywords für diesen Inhalt. Die Keywords sind durch Kommas getrennt, bestehen aus 1-3 Wörtern und spiegeln die Hauptthemen des Textes wider. Ich achte auf Suchvolumen und Relevanz, bevorzuge spezifische Begriffe anstelle allgemeiner Terme.'
];
```

#### Übersetzung mit Beibehaltung von Fachbegriffen
```php
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['config']['fieldWizard']['aiTextTranslation'] = [
    'renderType' => 'aiTextTranslationRteWizard',
    'iDoThisForYou' => 'Ich übersetze diesen Text präzise und sinngemäß. Fachbegriffe und Eigennamen übernehme ich unverändert. Die HTML-Struktur mit allen Tags (<p>, <h2>, etc.) bleibt erhalten. Ich passe die Übersetzung an kulturelle Besonderheiten der Zielsprache an, behalte aber den Stil und Ton des Originals bei.'
];
```

## Support

Bei Fragen oder Problemen wenden Sie sich bitte an:

i-gelb GmbH
[Website](https://www.i-gelb.de)

## Lizenz

Diese Extension wird unter der GPL-2.0-or-later Lizenz veröffentlicht.
