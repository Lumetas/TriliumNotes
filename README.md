# TriliumNotesPHP

## Оглавление

-   [*Русская версия*](README-rus.md)
-   [*English version*](README.md)

## Introduction

PHP client for [Trilium Notes](https://github.com/zadam/trilium) ETAPI.
Allows programmatic management of notes, branches, attributes and
attachments.

## Installation

Install via composer:

``` {.bash org-language="sh"}
composer require lumetas/trilium-notes
```

## Quick Start

``` php
<?php
require 'vendor/autoload.php';

use Lumetas\TriliumNotes\Trilium;

$trilium = new Trilium('http://localhost:37740/etapi', 'your-auth-token');

// Create a note
$note = $trilium->createNote(
    'root',
    'New Note',
    'text',
    'Note content'
);

// Get content
echo $note->getNote()->getContent();
```

## Core Classes

### Trilium

Main API client class. Takes endpoint and auth token.

Key methods:

-   `getNoteById()` - get note by ID
-   `createNote()` - create new note
-   `searchNotes()` - search notes
-   `createAttribute()` - create attribute

### Note

Class for working with notes.

Key methods:

-   `getContent()` / `writeContent()` - content management
-   `getAttributes()` - get attributes
-   `createLabel()` / `createRelation()` - create label/relation
-   `export()` / `import()` - export/import

### Branch

Class for working with branches (note relationships).

### Attribute

Class for working with attributes (labels and relations).

### Attachment

Class for working with attachments.

## Examples

### Create Note with Label

``` php
$noteWithBranch = $trilium->createNote(
    'root',
    'Note with label',
    'text',
    'Content'
);

$note = $noteWithBranch->getNote();
$note->createLabel('important', 'high');
```

### Search Notes

``` php
$notes = $trilium->searchNotes('search query', [
    'ancestorNoteId' => 'root',
    'limit' => 10
]);

foreach ($notes as $note) {
    echo $note->getTitle();
}
```

## Links

-   [Note source code](Note.php)
-   [Trilium source code](Trilium.php)
-   [ETAPI Documentation](https://github.com/zadam/trilium/wiki/ETAPI)
-   [Russian version](#русская-версия) →
