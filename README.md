# IG AIFORMS - KI-Integration für TYPO3

Diese TYPO3-Extension integriert KI-Funktionalitäten in das TYPO3-Backend und ermöglicht die Generierung und Übersetzung von Inhalten mit Hilfe von OpenAI.

## Funktionen

- KI-gestützte Textgenerierung für reguläre Felder
- KI-gestützte Textgenerierung für RTE-Felder (CKEditor)
- KI-gestützte Bildanalyse für Metadaten (Alt-Text, Beschreibungen)
- PDF-Analyse und Textextraktion mit KI
- SEO-Optimierung für Seiten (Meta-Beschreibungen, Titel, Keywords)
- Social Media Optimierung (Open Graph, Twitter Cards)

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

### Repository-Konfiguration

Fügen Sie die folgenden Repositories zu Ihrer composer.json hinzu:

```json
"repositories": [
    {
        "type": "composer",
        "url": "https://composer.typo3.org/"
    },
    {
        "type": "vcs",
        "url": "https://github.com/ai-gelb/ig_aiforms"
    }
],
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

#### Bildanalyse für Metadaten

```php
$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'fileExtension' => ['jpg', 'jpeg', 'png', 'gif'],
    'iDoThisForYou' => 'Ich erstelle einen Alt-Text für dieses Bild. Maximal 100 Zeichen.'
];
```

### Erweiterte Beispiele für verschiedene Anwendungsfälle

#### Präzise Alt-Text-Generierung für Bilder
```php
$GLOBALS['TCA']['sys_file_metadata']['columns']['alternative']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'fileExtension' => ['jpg', 'jpeg', 'png', 'gif'],
    'IDoThisForYou' => 'I provide a functional, objective description of the provided image in no more than around 30 words so that someone who could not see it would be able to imagine it. If possible, follow an "object-action-context" framework: The object is the main focus. The action describes what's happening, usually what the object is doing. The context describes the surrounding environment.
    If there is text found in the image, it is very important that you transcribe all of it, even if it extends the word count beyond 30 words.
    If there is no text found in the image, then there is no need to mention it.
    I should not begin the description with any variation of "The image".',
];
```

#### Umfangreiche Bildbeschreibung
```php
$GLOBALS['TCA']['sys_file_metadata']['columns']['description']['config']['fieldWizard']['aiImageMetadata'] = [
    'renderType' => 'aiImageMetadataWizard',
    'fileExtension' => ['jpg', 'jpeg', 'png', 'gif'],
    'IDoThisForYou' => 'I give you an description Text for this Image. Maximal 200 letters.',
];
```

#### SEO-Optimierungen für Seitenelemente
```php
// Meta-Beschreibung für Suchmaschinen
$GLOBALS['TCA']['pages']['columns']['description']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please provide a description for this page. I'll send you an HTML document. Use only the body. This description should be for search engines, like Google. The description should be between 120-160 characters. Don't use this character: ":"'
];

// SEO-Titel
$GLOBALS['TCA']['pages']['columns']['seo_title']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please give me a title for this page. I'll send you an HTML document. Only use the body. This title should be optimized for search engines, like Google. The title should be a maximum of 60 characters. Don't use this character: ":"'
];

// Open Graph Beschreibung (Facebook)
$GLOBALS['TCA']['pages']['columns']['og_description']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please provide a description for this page. I'll send you an HTML document. Use only the body. This description should be for social media: Facebook. The description should be between 120-160 characters. Don't use this character: ":"'
];

// Open Graph Titel (Facebook)
$GLOBALS['TCA']['pages']['columns']['og_title']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please give me a title for this page. I'll send you an HTML document. Only use the body. This title should be optimized for social media: Facebook. The title should be a maximum of 60 characters. Don't use this character: ":"'
];

// Twitter Card Beschreibung
$GLOBALS['TCA']['pages']['columns']['twitter_description']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please provide a description for this page. I'll send you an HTML document. Use only the body. This description should be for social media: Twitter Cards(X). The description should be between 120-160 characters. Don't use this character: ":"'
];

// Twitter Card Titel
$GLOBALS['TCA']['pages']['columns']['twitter_title']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please give me a title for this page. I'll send you an HTML document. Only use the body. This title should be optimized for social media: Twitter Cards(X). The title should be a maximum of 60 characters. Don't use this character: ":"'
];

// Keywords für Suchmaschinen
$GLOBALS['TCA']['pages']['columns']['keywords']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiPageTextWizard',
    'IDoThisForYou' => 'Please give me keywords for this page. I'll send you an HTML document. Use only the body. These titles should be for search engines, like Google. About five. Please comma-separated.'
];
```

#### News-Extension Integration
```php

// Keyword-Generierung aus News-Inhalten
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['keywords']['config']['fieldWizard']['aiText'] = [
    'renderType' => 'aiTextWizard',
    'aiToRead' => 'title,bodytext',
    'iDoThisForYou' => 'I give you 5 keywords from this News title and bodytext. Is separated by comma.'
];
```

## Verfügbare Wizard-Typen

- `aiTextWizard`: Für normale Textfelder
- `aiTextRteWizard`: Für RTE-Felder (CKEditor)
- `aiImageMetadataWizard`: Für Bildmetadaten
- `aiPageTextWizard`: Für seitenbasierte Textgenerierung
- `aiGenerateRteWizard`: Für komplexe RTE-Inhalte mit PDF-Quellen

## Anpassung der Prompts

Die Anweisungen für die KI können über die `iDoThisForYou`-Parameter in der TCA-Konfiguration angepasst werden. Hier können Sie detaillierte Anweisungen für die Generierung oder Übersetzung von Inhalten festlegen.

## Sicherheitshinweise

- Achten Sie darauf, dass Ihr OpenAI API-Schlüssel sicher gespeichert und nicht öffentlich zugänglich ist.
- Prüfen Sie die generierten Inhalte vor der Veröffentlichung auf Korrektheit und Angemessenheit.
- Beachten Sie die Datenschutzbestimmungen und informieren Sie Ihre Nutzer über den Einsatz von KI-Technologien.

## Support

Bei Fragen oder Problemen wenden Sie sich bitte an:

i-gelb GmbH
[Website](https://www.i-gelb.de)

