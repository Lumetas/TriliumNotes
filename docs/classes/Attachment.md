# \Lumetas\TriliumNotes\Attachment


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

Получить ID вложения



#### Return
string - ID вложения


### getOwnerId()

```php
function getOwnerId(): string
```

Получить ID владельца (заметки или ревизии)



#### Return
string - ID владельца


### getRole()

```php
function getRole(): string
```

Получить роль вложения



#### Return
string - Роль вложения


### setRole()

```php
function setRole(string $role): void
```

Установить новую роль вложения



#### Param
- `role` (string) - Новая роль

#### Throws
- 


### getMime()

```php
function getMime(): string
```

Получить MIME-тип вложения



#### Return
string - MIME-тип


### setMime()

```php
function setMime(string $mime): void
```

Установить новый MIME-тип вложения



#### Param
- `mime` (string) - Новый MIME-тип

#### Throws
- 


### getTitle()

```php
function getTitle(): string
```

Получить заголовок вложения



#### Return
string - Заголовок вложения


### setTitle()

```php
function setTitle(string $title): void
```

Установить новый заголовок вложения



#### Param
- `title` (string) - Новый заголовок

#### Throws
- 


### getPosition()

```php
function getPosition(): int
```

Получить позицию вложения



#### Return
int - Позиция вложения


### setPosition()

```php
function setPosition(int $position): void
```

Установить новую позицию вложения



#### Param
- `position` (int) - Новая позиция

#### Throws
- 


### getBlobId()

```php
function getBlobId(): string
```

Получить ID blob-объекта (хеш содержимого)



#### Return
string - ID blob-объекта


### getDateModified()

```php
function getDateModified(): string
```

Получить дату изменения в локальном времени



#### Return
string - Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSS±HHMM"


### getUtcDateModified()

```php
function getUtcDateModified(): string
```

Получить дату изменения в UTC



#### Return
string - Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSSZ"


### getUtcDateScheduledForErasureSince()

```php
function getUtcDateScheduledForErasureSince(): ?string
```

Получить дату планируемого удаления в UTC



#### Return
string|null - Дата в формате "YYYY-MM-DD HH:MM:SS.SSSZ" или null если не установлено


### getContentLength()

```php
function getContentLength(): int
```

Получить длину содержимого вложения



#### Return
int - Длина содержимого в байтах


### getContent()

```php
function getContent(): string
```

Получить содержимое вложения



#### Return
string - Содержимое вложения

#### Throws
- 


### writeContent()

```php
function writeContent(string $content): void
```

Записать новое содержимое вложения



#### Param
- `content` (string) - Новое содержимое

#### Throws
- 


### getOwner()

```php
function getOwner(): \Lumetas\TriliumNotes\Note
```

Получить объект владельца (заметки)



#### Return
\Lumetas\TriliumNotes\Note - Объект заметки

#### Throws
- 


### delete()

```php
function delete(): void
```

Удалить вложение



#### Throws
- 


### update()

```php
function update(array $data): void
```

Обновить данные вложения



#### Param
- `data` (array) - Данные для обновления

#### Throws
- 

