# \Lumetas\TriliumNotes\Attribute


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

Получить ID атрибута



#### Return
string - ID атрибута


### getNoteId()

```php
function getNoteId(): string
```

Получить ID заметки



#### Return
string - ID заметки


### getType()

```php
function getType(): string
```

Получить тип атрибута (label или relation)



#### Return
string - Тип атрибута


### getName()

```php
function getName(): string
```

Получить имя атрибута



#### Return
string - Имя атрибута


### getValue()

```php
function getValue(): ?string
```

Получить значение атрибута



#### Return
string|null - Значение атрибута или null если отсутствует


### setValue()

```php
function setValue(string $value): void
```

Установить новое значение атрибута (только для меток)



#### Param
- `value` (string) - Новое значение

#### Throws
- 


### getPosition()

```php
function getPosition(): int
```

Получить позицию атрибута



#### Return
int - Позиция атрибута


### setPosition()

```php
function setPosition(int $position): void
```

Установить новую позицию атрибута



#### Param
- `position` (int) - Новая позиция

#### Throws
- 


### isInheritable()

```php
function isInheritable(): bool
```

Проверить, наследуемый ли атрибут



#### Return
bool - True если атрибут наследуемый


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


### delete()

```php
function delete(): void
```

Удалить атрибут



#### Throws
- 


### update()

```php
function update(array $data): void
```

Обновить данные атрибута



#### Param
- `data` (array) - Данные для обновления

#### Throws
- 

