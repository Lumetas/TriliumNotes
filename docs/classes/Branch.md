# \Lumetas\TriliumNotes\Branch


## Properties

#### $trilium

```php
private \Lumetas\TriliumNotes\Trilium $trilium
```


#### $data

```php
private array $data
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

Получить ID ветки



#### Return
string - ID ветки


### getNoteId()

```php
function getNoteId(): string
```

Получить ID заметки



#### Return
string - ID заметки


### getParentNoteId()

```php
function getParentNoteId(): string
```

Получить ID родительской заметки



#### Return
string - ID родительской заметки


### getPrefix()

```php
function getPrefix(): string
```

Получить префикс заголовка



#### Return
string - Префикс заголовка


### setPrefix()

```php
function setPrefix(string $prefix): void
```

Установить префикс заголовка



#### Param
- `prefix` (string) - Новый префикс

#### Throws
- 


### getNotePosition()

```php
function getNotePosition(): int
```

Получить позицию заметки



#### Return
int - Позиция заметки


### setNotePosition()

```php
function setNotePosition(int $position): void
```

Установить позицию заметки



#### Param
- `position` (int) - Новая позиция

#### Throws
- 


### isExpanded()

```php
function isExpanded(): bool
```

Проверить, раскрыта ли ветка



#### Return
bool - True если ветка раскрыта


### setExpanded()

```php
function setExpanded(bool $expanded): void
```

Установить, раскрыта ли ветка



#### Param
- `expanded` (bool) - Раскрыть или свернуть ветку

#### Throws
- 


### getUtcDateModified()

```php
function getUtcDateModified(): string
```

Получить дату изменения в UTC



#### Return
string - Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSSZ"


### getNote()

```php
function getNote(): \Lumetas\TriliumNotes\Note
```

Получить объект заметки



#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### getParentNote()

```php
function getParentNote(): \Lumetas\TriliumNotes\Note
```

Получить объект родительской заметки



#### Return
\Lumetas\TriliumNotes\Note - Объект родительской заметки

#### Throws
- 


### delete()

```php
function delete(): void
```

Удалить ветку



#### Throws
- 


### update()

```php
function update(array $data): void
```

Обновить данные ветки



#### Param
- `data` (array) - Данные для обновления

#### Throws
- 

