# TriliumNotesPHP

## Языки

-   [*Русская версия*](README-rus.md)
-   [*English version*](README.md)

## Введение

PHP клиент для работы с [Trilium
Notes](https://github.com/zadam/trilium) через ETAPI. Позволяет
управлять заметками, ветками, атрибутами и вложениями программно.

## Установка

Установите через composer:

``` {.bash org-language="sh"}
composer require lumetas/trilium-notes
```

## Быстрый старт

``` php
<?php
require 'vendor/autoload.php';

use Lumetas\TriliumNotes\Trilium;

$trilium = new Trilium('http://localhost:37740/etapi', 'your-auth-token');

// Создание заметки
$note = $trilium->createNote(
    'root', 
    'Новая заметка',
    'text',
    'Содержимое заметки'
);

// Получение содержимого
echo $note->getContent();
```

## Основные классы

### Trilium

Основной класс для работы с API. Принимает endpoint и токен
аутентификации.

Основные методы:

-   `getNoteById()` - получить заметку по ID
-   `createNote()` - создать новую заметку
-   `searchNotes()` - поиск заметок
-   `createAttribute()` - создать атрибут

### Note

Класс для работы с заметками.

Основные методы:

-   `getContent()` / `writeContent()` - работа с содержимым
-   `getAttributes()` - получить атрибуты
-   `createLabel()` / `createRelation()` - создать метку/отношение
-   `export()` / `import()` - экспорт/импорт

### Branch

Класс для работы с ветками (связями между заметками).

### Attribute

Класс для работы с атрибутами (метками и отношениями).

### Attachment

Класс для работы с вложениями.

## Примеры

### Создание заметки с меткой

``` php
$noteWithBranch = $trilium->createNote(
    'root',
    'Заметка с меткой',
    'text',
    'Содержимое'
);

$note = $noteWithBranch->getNote();
$note->createLabel('important', 'high');
```

### Поиск заметок

``` php
$notes = $trilium->searchNotes('поисковый запрос', [
    'ancestorNoteId' => 'root',
    'limit' => 10
]);

foreach ($notes as $note) {
    echo $note->getTitle();
}
```

## Ссылки

-   [Исходный код Note](Note.php)
-   [Исходный код Trilium](Trilium.php)
-   [Документация ETAPI](https://github.com/zadam/trilium/wiki/ETAPI)
-   [English version](#english-version) →
