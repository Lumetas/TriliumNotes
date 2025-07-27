# \Lumetas\TriliumNotes\Note


## Properties

#### $trilium

```php
private \Lumetas\TriliumNotes\Trilium $trilium
```


#### $data

```php
private array $data
```


#### $attributes

```php
private ?array $attributes = null
```


## Methods

### __construct()

```php
function __construct(\Lumetas\TriliumNotes\Trilium $trilium, array $data): mixed
```


### getId()

```php
function getId(): string
```

Получить ID заметки



#### Return
string - ID заметки


### getTitle()

```php
function getTitle(): string
```

Получить заголовок заметки



#### Return
string - Заголовок заметки


### setTitle()

```php
function setTitle(string $title): void
```

Установить новый заголовок заметки



#### Param
- `title` (string) - Новый заголовок

#### Throws
- 


### getType()

```php
function getType(): string
```

Получить тип заметки



#### Return
string - Тип заметки (text, code, file и т.д.)


### getMime()

```php
function getMime(): string
```

Получить MIME-тип содержимого



#### Return
string - MIME-тип


### setMime()

```php
function setMime(string $mime): void
```

Установить MIME-тип содержимого



#### Param
- `mime` (string) - Новый MIME-тип

#### Throws
- 


### isProtected()

```php
function isProtected(): bool
```

Проверить, защищена ли заметка



#### Return
bool - True если заметка защищена


### getContent()

```php
function getContent(): string
```

Получить содержимое заметки



#### Return
string - Содержимое заметки

#### Throws
- 


### writeContent()

```php
function writeContent(string $content): void
```

Записать новое содержимое заметки



#### Param
- `content` (string) - Новое содержимое

#### Throws
- 


### appendContent()

```php
function appendContent(string $content): void
```

Добавить текст к существующему содержимому



#### Param
- `content` (string) - Дополнительный текст

#### Throws
- 


### export()

```php
function export(string $format = 'html'): object
```

Экспортировать поддерево заметки



#### Param
- `format` (string) - Формат экспорта (html или markdown)

#### Return
object - ZIP архив. $zip->write("file.zip");

#### Throws
- 


### import()

```php
function import(string $zipData): \Lumetas\TriliumNotes\NoteWithBranch
```

Импортировать ZIP-архив в заметку



#### Param
- `zipData` (string) - Бинарные данные ZIP-архива

#### Return
\Lumetas\TriliumNotes\NoteWithBranch - Объект созданной заметки с информацией о ветке

#### Throws
- 


### createRevision()

```php
function createRevision(string $format = 'html'): void
```

Создать ревизию заметки



#### Param
- `format` (string) - Формат ревизии (html или markdown)

#### Throws
- 


### getAttributes()

```php
function getAttributes(): array
```

Получить список атрибутов (меток и отношений)



#### Return
array - Ассоциативный массив атрибутов

#### Throws
- 


### forAttributes()

```php
function forAttributes(): \Generator
```

Генератор для итерации по атрибутам



#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Attribute[] - Генератор объектов Attribute

#### Throws
- 


### getAttribute()

```php
function getAttribute(string $name): ?\Lumetas\TriliumNotes\Attribute
```

Получить атрибут по имени



#### Param
- `name` (string) - Имя атрибута

#### Return
\Lumetas\TriliumNotes\Attribute|null - Объект атрибута или null если не найден

#### Throws
- 


### createLabel()

```php
function createLabel(string $name, ?string $value = null, array $options = []): \Lumetas\TriliumNotes\Attribute
```

Создать метку



#### Param
- `name` (string) - Имя метки

#### Param
- `value` (string|null) - Значение метки (опционально)

#### Param
- `options` (array) - Дополнительные параметры:
- position: int - позиция метки
- isInheritable: bool - наследуемая ли метка

#### Return
\Lumetas\TriliumNotes\Attribute - Объект созданной метки

#### Throws
- 


### createRelation()

```php
function createRelation(string $name, string $targetNoteId, array $options = []): \Lumetas\TriliumNotes\Attribute
```

Создать отношение



#### Param
- `name` (string) - Имя отношения

#### Param
- `targetNoteId` (string) - ID целевой заметки

#### Param
- `options` (array) - Дополнительные параметры:
- position: int - позиция отношения
- isInheritable: bool - наследуемое ли отношение

#### Return
\Lumetas\TriliumNotes\Attribute - Объект созданного отношения

#### Throws
- 


### getParentNoteIds()

```php
function getParentNoteIds(): array
```

Получить список ID родительских заметок



#### Return
string[] - Массив ID родительских заметок


### getChildNoteIds()

```php
function getChildNoteIds(): array
```

Получить список ID дочерних заметок



#### Return
string[] - Массив ID дочерних заметок


### getParentBranchIds()

```php
function getParentBranchIds(): array
```

Получить список ID родительских веток



#### Return
string[] - Массив ID родительских веток


### getChildBranchIds()

```php
function getChildBranchIds(): array
```

Получить список ID дочерних веток



#### Return
string[] - Массив ID дочерних веток


### getParentNotes()

```php
function getParentNotes(): \Generator
```

Получить родительские заметки



#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Note[] - Генератор объектов Note

#### Throws
- 


### forChildNotes()

```php
function forChildNotes(): \Generator
```

Получить дочерние заметки через генератор



#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Note[] - Генератор объектов Note

#### Throws
- 


### getChildNotes()

```php
function getChildNotes(): array
```

Получить дочерние заметки через генератор



#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Note[] - Генератор объектов Note

#### Throws
- 


### getParentBranches()

```php
function getParentBranches(): \Generator
```

Получить родительские ветки



#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Branch[] - Генератор объектов Branch

#### Throws
- 


### getChildBranches()

```php
function getChildBranches(): \Generator
```

Получить дочерние ветки



#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Branch[] - Генератор объектов Branch

#### Throws
- 


### getDateCreated()

```php
function getDateCreated(): string
```

Получить дату создания в локальном времени



#### Return
string - Дата создания в формате "YYYY-MM-DD HH:MM:SS.SSS±HHMM"


### getDateModified()

```php
function getDateModified(): string
```

Получить дату изменения в локальном времени



#### Return
string - Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSS±HHMM"


### getUtcDateCreated()

```php
function getUtcDateCreated(): string
```

Получить дату создания в UTC



#### Return
string - Дата создания в формате "YYYY-MM-DD HH:MM:SS.SSSZ"


### getUtcDateModified()

```php
function getUtcDateModified(): string
```

Получить дату изменения в UTC



#### Return
string - Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSSZ"


### delete()

```php
function delete(): void
```

Удалить заметку



#### Throws
- 


### update()

```php
function update(array $data): void
```

Обновить данные заметки



#### Param
- `data` (array) - Данные для обновления

#### Throws
- 

