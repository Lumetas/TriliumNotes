<?php
namespace Lumetas\TriliumNotes;
class Note
{
	private Trilium $trilium;
	private array $data;
	private ?array $attributes = null;

	public function __construct(Trilium $trilium, array $data)
	{
		$this->trilium = $trilium;
		$this->data = $data;
	}

	/**
	 * Получить ID заметки
	 *
	 * @return string ID заметки
	 */
	public function getId(): string
	{
		return $this->data['noteId'];
	}

	/**
	 * Получить заголовок заметки
	 *
	 * @return string Заголовок заметки
	 */
	public function getTitle(): string
	{
		return $this->data['title'];
	}

	/**
	 * Установить новый заголовок заметки
	 *
	 * @param string $title Новый заголовок
	 * @throws Exception
	 */
	public function setTitle(string $title): void
	{
		$this->update(['title' => $title]);
	}

	/**
	 * Получить тип заметки
	 *
	 * @return string Тип заметки (text, code, file и т.д.)
	 */
	public function getType(): string
	{
		return $this->data['type'];
	}

	/**
	 * Получить MIME-тип содержимого
	 *
	 * @return string MIME-тип
	 */
	public function getMime(): string
	{
		return $this->data['mime'];
	}

	/**
	 * Установить MIME-тип содержимого
	 *
	 * @param string $mime Новый MIME-тип
	 * @throws Exception
	 */
	public function setMime(string $mime): void
	{
		$this->update(['mime' => $mime]);
	}

	/**
	 * Проверить, защищена ли заметка
	 *
	 * @return bool True если заметка защищена
	 */
	public function isProtected(): bool
	{
		return $this->data['isProtected'];
	}

	/**
	 * Получить содержимое заметки
	 *
	 * @return string Содержимое заметки
	 * @throws Exception
	 */
	public function getContent(): string
	{
		return $this->trilium->requestRaw('GET', "/notes/{$this->getId()}/content", null, 200);
	}

	/**
	 * Записать новое содержимое заметки
	 *
	 * @param string $content Новое содержимое
	 * @throws Exception
	 */
	public function writeContent(string $content): void
	{
		$this->trilium->requestRaw('PUT', "/notes/{$this->getId()}/content", $content, 204, ["Content-Type: text/plain"]);
	}

	/**
	 * Добавить текст к существующему содержимому
	 *
	 * @param string $content Дополнительный текст
	 * @throws Exception
	 */
	public function appendContent(string $content): void
	{
		$currentContent = $this->getContent();
		$this->writeContent($currentContent . $content);
	}

	/**
	 * Экспортировать поддерево заметки
	 *
	 * @param string $format Формат экспорта (html или markdown)
	 * @return object ZIP архив. $zip->write("file.zip");
	 * @throws Exception
	 *
	 */
	public function export(string $format = 'html'): object
	{
		$rawZip = $this->trilium->requestRaw('GET', "/notes/{$this->getId()}/export", ['format' => $format], 200);

		$zip = new class {
			public $content;

			public function write($filename) {
				file_put_contents($filename, $this->content);
			}
		};

		$zip->content = $rawZip;

		return $zip;

	}

	/**
	 * Импортировать ZIP-архив в заметку
	 *
	 * @param string $zipData Бинарные данные ZIP-архива
	 * @return NoteWithBranch Объект созданной заметки с информацией о ветке
	 * @throws Exception
	 */
	public function import(string $zipData): NoteWithBranch
	{
		$response = $this->trilium->request('POST', "/notes/{$this->getId()}/import", $zipData, 201);
		return new NoteWithBranch(
			new Note($this->trilium, $response['note']),
			new Branch($this->trilium, $response['branch'])
		);
	}

	/**
	 * Создать ревизию заметки
	 *
	 * @param string $format Формат ревизии (html или markdown)
	 * @throws Exception
	 */
	public function createRevision(string $format = 'html'): void
	{
		$this->trilium->request('POST', "/notes/{$this->getId()}/revision", ['format' => $format], 204);
	}

	/**
	 * Получить список атрибутов (меток и отношений)
	 *
	 * @return array Ассоциативный массив атрибутов
	 * @throws Exception
	 */
	public function getAttributes(): array
	{
		if ($this->attributes === null) {
			$this->attributes = [];
			foreach ($this->data['attributes'] as $attributeData) {
				$attribute = new Attribute($this->trilium, $attributeData);
				$this->attributes[$attribute->getName()] = $attribute;
			}
		}
		return $this->attributes;
	}

	/**
	 * Генератор для итерации по атрибутам
	 *
	 * @return Generator|Attribute[] Генератор объектов Attribute
	 * @throws Exception
	 */
	public function forAttributes(): \Generator
	{
		foreach ($this->getAttributes() as $name => $attribute) {
			yield $name => $attribute;
		}
	}

	/**
	 * Получить атрибут по имени
	 *
	 * @param string $name Имя атрибута
	 * @return Attribute|null Объект атрибута или null если не найден
	 * @throws Exception
	 */
	public function getAttribute(string $name): ?Attribute
	{
		return $this->getAttributes()[$name] ?? null;
	}

	/**
	 * Создать метку
	 *
	 * @param string $name Имя метки
	 * @param string|null $value Значение метки (опционально)
	 * @param array $options Дополнительные параметры:
	 *   - position: int - позиция метки
	 *   - isInheritable: bool - наследуемая ли метка
	 * @return Attribute Объект созданной метки
	 * @throws Exception
	 */
	public function createLabel(string $name, ?string $value = null, array $options = []): Attribute
	{
		return $this->trilium->createAttribute($this->getId(), 'label', $name, $value, $options);
	}

	/**
	 * Создать отношение
	 *
	 * @param string $name Имя отношения
	 * @param string $targetNoteId ID целевой заметки
	 * @param array $options Дополнительные параметры:
	 *   - position: int - позиция отношения
	 *   - isInheritable: bool - наследуемое ли отношение
	 * @return Attribute Объект созданного отношения
	 * @throws Exception
	 */
	public function createRelation(string $name, string $targetNoteId, array $options = []): Attribute
	{
		return $this->trilium->createAttribute($this->getId(), 'relation', $name, $targetNoteId, $options);
	}

	/**
	 * Получить список ID родительских заметок
	 *
	 * @return string[] Массив ID родительских заметок
	 */
	public function getParentNoteIds(): array
	{
		return $this->data['parentNoteIds'];
	}

	/**
	 * Получить список ID дочерних заметок
	 *
	 * @return string[] Массив ID дочерних заметок
	 */
	public function getChildNoteIds(): array
	{
		return $this->data['childNoteIds'];
	}

	/**
	 * Получить список ID родительских веток
	 *
	 * @return string[] Массив ID родительских веток
	 */
	public function getParentBranchIds(): array
	{
		return $this->data['parentBranchIds'];
	}

	/**
	 * Получить список ID дочерних веток
	 *
	 * @return string[] Массив ID дочерних веток
	 */
	public function getChildBranchIds(): array
	{
		return $this->data['childBranchIds'];
	}

	/**
	 * Получить родительские заметки
	 *
	 * @return Generator|Note[] Генератор объектов Note
	 * @throws Exception
	 */
	public function getParentNotes(): \Generator
	{
		foreach ($this->getParentNoteIds() as $noteId) {
			yield $this->trilium->getNoteById($noteId);
		}
	}

	/**
	 * Получить дочерние заметки через генератор
	 *
	 * @return Generator|Note[] Генератор объектов Note
	 * @throws Exception
	 */
	public function forChildNotes(): \Generator
	{
		foreach ($this->getChildNoteIds() as $noteId) {
			yield $this->trilium->getNoteById($noteId);
		}
	}

	/**
	 * Получить дочерние заметки через генератор
	 *
	 * @return Generator|Note[] Генератор объектов Note
	 * @throws Exception
	 */
	public function getChildNotes(): array
	{
		$notes = [];
		foreach ($this->getChildNoteIds() as $noteId) {
			$notes[] = $this->trilium->getNoteById($noteId);
		}
		return $notes;
	}

	/**
	 * Получить родительские ветки
	 *
	 * @return Generator|Branch[] Генератор объектов Branch
	 * @throws Exception
	 */
	public function getParentBranches(): \Generator
	{
		foreach ($this->getParentBranchIds() as $branchId) {
			yield $this->trilium->getBranchById($branchId);
		}
	}

	/**
	 * Получить дочерние ветки
	 *
	 * @return Generator|Branch[] Генератор объектов Branch
	 * @throws Exception
	 */
	public function getChildBranches(): \Generator
	{
		foreach ($this->getChildBranchIds() as $branchId) {
			yield $this->trilium->getBranchById($branchId);
		}
	}

	/**
	 * Получить дату создания в локальном времени
	 *
	 * @return string Дата создания в формате "YYYY-MM-DD HH:MM:SS.SSS±HHMM"
	 */
	public function getDateCreated(): string
	{
		return $this->data['dateCreated'];
	}

	/**
	 * Получить дату изменения в локальном времени
	 *
	 * @return string Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSS±HHMM"
	 */
	public function getDateModified(): string
	{
		return $this->data['dateModified'];
	}

	/**
	 * Получить дату создания в UTC
	 *
	 * @return string Дата создания в формате "YYYY-MM-DD HH:MM:SS.SSSZ"
	 */
	public function getUtcDateCreated(): string
	{
		return $this->data['utcDateCreated'];
	}

	/**
	 * Получить дату изменения в UTC
	 *
	 * @return string Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSSZ"
	 */
	public function getUtcDateModified(): string
	{
		return $this->data['utcDateModified'];
	}

	/**
	 * Удалить заметку
	 *
	 * @throws Exception
	 */
	public function delete(): void
	{
		$this->trilium->request('DELETE', "/notes/{$this->getId()}", null, 204);
	}

	/**
	 * Обновить данные заметки
	 *
	 * @param array $data Данные для обновления
	 * @throws Exception
	 */
	private function update(array $data): void
	{
		$this->data = $this->trilium->request('PATCH', "/notes/{$this->getId()}", $data);
	}
}
