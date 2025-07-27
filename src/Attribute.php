<?php
namespace Lumetas\TriliumNotes;
class Attribute
{
    private Trilium $trilium;
    private array $data;

    public function __construct(Trilium $trilium, array $data)
    {
        $this->trilium = $trilium;
        $this->data = $data;
    }

    /**
     * Получить ID атрибута
     *
     * @return string ID атрибута
     */
    public function getId(): string
    {
        return $this->data['attributeId'];
    }

    /**
     * Получить ID заметки
     *
     * @return string ID заметки
     */
    public function getNoteId(): string
    {
        return $this->data['noteId'];
    }

    /**
     * Получить тип атрибута (label или relation)
     *
     * @return string Тип атрибута
     */
    public function getType(): string
    {
        return $this->data['type'];
    }

    /**
     * Получить имя атрибута
     *
     * @return string Имя атрибута
     */
    public function getName(): string
    {
        return $this->data['name'];
    }

    /**
     * Получить значение атрибута
     *
     * @return string|null Значение атрибута или null если отсутствует
     */
    public function getValue(): ?string
    {
        return $this->data['value'] ?? null;
    }

    /**
     * Установить новое значение атрибута (только для меток)
     *
     * @param string $value Новое значение
     * @throws Exception
     */
    public function setValue(string $value): void
    {
        if ($this->getType() !== 'label') {
            throw new Exception('Only label attributes can have their values updated');
        }
        $this->update(['value' => $value]);
    }

    /**
     * Получить позицию атрибута
     *
     * @return int Позиция атрибута
     */
    public function getPosition(): int
    {
        return $this->data['position'];
    }

    /**
     * Установить новую позицию атрибута
     *
     * @param int $position Новая позиция
     * @throws Exception
     */
    public function setPosition(int $position): void
    {
        $this->update(['position' => $position]);
    }

    /**
     * Проверить, наследуемый ли атрибут
     *
     * @return bool True если атрибут наследуемый
     */
    public function isInheritable(): bool
    {
        return $this->data['isInheritable'];
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
     * Получить объект заметки
     *
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getNote(): Note
    {
        return $this->trilium->getNoteById($this->getNoteId());
    }

    /**
     * Удалить атрибут
     *
     * @throws Exception
     */
    public function delete(): void
    {
        $this->trilium->request('DELETE', "/attributes/{$this->getId()}", null, 204);
    }

    /**
     * Обновить данные атрибута
     *
     * @param array $data Данные для обновления
     * @throws Exception
     */
    private function update(array $data): void
    {
        $this->data = $this->trilium->request('PATCH', "/attributes/{$this->getId()}", $data);
    }
}
