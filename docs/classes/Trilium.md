# \Lumetas\TriliumNotes\Trilium


## Properties

#### $endpoint

```php
private string $endpoint
```


#### $authToken

```php
private string $authToken
```


## Methods

### __construct()

```php
function __construct(string $endpoint, string $authToken): mixed
```

Конструктор Trilium ETAPI клиента



#### Param
- `endpoint` (string) - Базовый URL ETAPI (например, "http://localhost:37740/etapi")

#### Param
- `authToken` (string) - Токен аутентификации ETAPI


### getAppInfo()

```php
function getAppInfo(): array
```

Получить информацию о приложении Trilium



#### Return
array - Массив с информацией о приложении

#### Throws
- 


### createBackup()

```php
function createBackup(string $backupName): void
```

Создать резервную копию базы данных



#### Param
- `backupName` (string) - Имя резервной копии (будет использовано в имени файла)

#### Throws
- 


### getNoteById()

```php
function getNoteById(string $noteId): \Lumetas\TriliumNotes\Note
```

Получить заметку по ID



#### Param
- `noteId` (string) - ID заметки

#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### forSearchNotes()

```php
function forSearchNotes(string $searchQuery, array $options = []): \Generator
```

Поиск заметок через Generator



#### Param
- `searchQuery` (string) - Строка поиска

#### Param
- `options` (array) - Дополнительные параметры поиска:
- fastSearch: bool - быстрый поиск (не ищет в содержимом)
- includeArchivedNotes: bool - включать архивированные заметки
- ancestorNoteId: string - искать только в поддереве
- ancestorDepth: string - глубина поиска (eq1, eq3, lt4, gt4 и т.д.)
- orderBy: string - поле для сортировки
- orderDirection: string - направление сортировки (asc/desc)
- limit: int - ограничение количества результатов

#### Return
\Lumetas\TriliumNotes\Generator|\Lumetas\TriliumNotes\Note[] - Генератор объектов Note

#### Throws
- 


### searchNotes()

```php
function searchNotes(string $searchQuery, array $options = []): array
```

Поиск заметок через



#### Param
- `searchQuery` (string) - Строка поиска

#### Param
- `options` (array) - Дополнительные параметры поиска:
- fastSearch: bool - быстрый поиск (не ищет в содержимом)
- includeArchivedNotes: bool - включать архивированные заметки
- ancestorNoteId: string - искать только в поддереве
- ancestorDepth: string - глубина поиска (eq1, eq3, lt4, gt4 и т.д.)
- orderBy: string - поле для сортировки
- orderDirection: string - направление сортировки (asc/desc)
- limit: int - ограничение количества результатов

#### Return
array|\Lumetas\TriliumNotes\Note[] - Генератор объектов Note

#### Throws
- 


### createNote()

```php
function createNote(string $parentNoteId, string $title, string $type, string $content, array $options = []): \Lumetas\TriliumNotes\NoteWithBranch
```

Создать новую заметку



#### Param
- `parentNoteId` (string) - ID родительской заметки

#### Param
- `title` (string) - Заголовок заметки

#### Param
- `type` (string) - Тип заметки (text, code, file, image и т.д.)

#### Param
- `content` (string) - Содержимое заметки

#### Param
- `options` (array) - Дополнительные параметры:
- mime: string - MIME-тип (для типов code, file, image)
- notePosition: int - позиция заметки
- prefix: string - префикс заголовка
- isExpanded: bool - раскрыта ли папка

#### Return
\Lumetas\TriliumNotes\NoteWithBranch - Объект созданной заметки с информацией о ветке

#### Throws
- 


### getInboxNote()

```php
function getInboxNote(string $date): \Lumetas\TriliumNotes\Note
```

Получить заметку "входящие" для указанной даты



#### Param
- `date` (string) - Дата в формате YYYY-MM-DD

#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### getDayNote()

```php
function getDayNote(string $date): \Lumetas\TriliumNotes\Note
```

Получить дневную заметку для указанной даты



#### Param
- `date` (string) - Дата в формате YYYY-MM-DD

#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### getWeekNote()

```php
function getWeekNote(string $date): \Lumetas\TriliumNotes\Note
```

Получить недельную заметку для указанной даты



#### Param
- `date` (string) - Дата в формате YYYY-MM-DD

#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### getMonthNote()

```php
function getMonthNote(string $month): \Lumetas\TriliumNotes\Note
```

Получить месячную заметку для указанного месяца



#### Param
- `month` (string) - Месяц в формате YYYY-MM

#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### getYearNote()

```php
function getYearNote(string $year): \Lumetas\TriliumNotes\Note
```

Получить годовую заметку для указанного года



#### Param
- `year` (string) - Год в формате YYYY

#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### createBranch()

```php
function createBranch(string $parentNoteId, string $noteId, array $options = []): \Lumetas\TriliumNotes\Branch
```

Создать ветку (связь между заметками)



#### Param
- `parentNoteId` (string) - ID родительской заметки

#### Param
- `noteId` (string) - ID дочерней заметки

#### Param
- `options` (array) - Дополнительные параметры:
- prefix: string - префикс заголовка
- notePosition: int - позиция заметки
- isExpanded: bool - раскрыта ли папка

#### Return
\Lumetas\TriliumNotes\Branch - Объект созданной ветки

#### Throws
- 


### getBranchById()

```php
function getBranchById(string $branchId): \Lumetas\TriliumNotes\Branch
```

Получить ветку по ID



#### Param
- `branchId` (string) - ID ветки

#### Return
\Lumetas\TriliumNotes\Branch - Объект ветки

#### Throws
- 


### createAttribute()

```php
function createAttribute(string $noteId, string $type, string $name, ?string $value = null, array $options = []): \Lumetas\TriliumNotes\Attribute
```

Создать атрибут (метку или отношение)



#### Param
- `noteId` (string) - ID заметки

#### Param
- `type` (string) - Тип атрибута (label или relation)

#### Param
- `name` (string) - Имя атрибута

#### Param
- `value` (string|null) - Значение атрибута (опционально)

#### Param
- `options` (array) - Дополнительные параметры:
- position: int - позиция атрибута
- isInheritable: bool - наследуемый ли атрибут

#### Return
\Lumetas\TriliumNotes\Attribute - Объект атрибута

#### Throws
- 


### getAttributeById()

```php
function getAttributeById(string $attributeId): \Lumetas\TriliumNotes\Attribute
```

Получить атрибут по ID



#### Param
- `attributeId` (string) - ID атрибута

#### Return
\Lumetas\TriliumNotes\Attribute - Объект атрибута

#### Throws
- 


### createAttachment()

```php
function createAttachment(string $ownerId, string $role, string $mime, string $title, string $content, ?int $position = null): \Lumetas\TriliumNotes\Attachment
```

Создать вложение



#### Param
- `ownerId` (string) - ID владельца (заметки или ревизии)

#### Param
- `role` (string) - Роль вложения

#### Param
- `mime` (string) - MIME-тип

#### Param
- `title` (string) - Заголовок вложения

#### Param
- `content` (string) - Содержимое вложения

#### Param
- `position` (int|null) - Позиция вложения

#### Return
\Lumetas\TriliumNotes\Attachment - Объект вложения

#### Throws
- 


### getAttachmentById()

```php
function getAttachmentById(string $attachmentId): \Lumetas\TriliumNotes\Attachment
```

Получить вложение по ID



#### Param
- `attachmentId` (string) - ID вложения

#### Return
\Lumetas\TriliumNotes\Attachment - Объект вложения

#### Throws
- 


### refreshNoteOrdering()

```php
function refreshNoteOrdering(string $parentNoteId): void
```

Обновить порядок заметок для родительской заметки



#### Param
- `parentNoteId` (string) - ID родительской заметки

#### Throws
- 


### request()

```php
function request(string $method, string $path, mixed $data = null, mixed $expectedStatus = 200): array
```

Выполнить HTTP-запрос к ETAPI



#### Param
- `method` (string) - HTTP-метод (GET, POST, PUT, PATCH, DELETE)

#### Param
- `path` (string) - Путь API

#### Param
- `data` (mixed) - Данные для отправки

#### Param
- `expectedStatus` (int|array) - Ожидаемый HTTP-статус ответа

#### Return
array - Данные ответа

#### Throws
- 


### requestRaw()

```php
function requestRaw(string $method, string $path, mixed $data = null, mixed $expectedStatus = 200, array $customHeaders = []): string
```

Выполнить HTTP-запрос к ETAPI и получить сырое тело



#### Param
- `method` (string) - HTTP-метод (GET, POST, PUT, PATCH, DELETE)

#### Param
- `path` (string) - Путь API

#### Param
- `data` (mixed) - Данные для отправки

#### Param
- `expectedStatus` (int|array) - Ожидаемый HTTP-статус ответа

#### Return
string - Данные ответа

#### Throws
- 

