<?php
namespace Lumetas\TriliumNotes;
class Branch
{
    private Trilium $trilium;
    private array $data;

    public function __construct(Trilium $trilium, array $data)
    {
        $this->trilium = $trilium;
        $this->data = $data;
    }

    /**
     * Получить ID ветки
     *
     * @return string ID ветки
     */
    public function getId(): string
    {
        return $this->data['branchId'];
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
     * Получить ID родительской заметки
     *
     * @return string ID родительской заметки
     */
    public function getParentNoteId(): string
    {
        return $this->data['parentNoteId'];
    }

    /**
     * Получить префикс заголовка
     *
     * @return string Префикс заголовка
     */
    public function getPrefix(): string
    {
        return $this->data['prefix'];
    }

    /**
     * Установить префикс заголовка
     *
     * @param string $prefix Новый префикс
     * @throws Exception
     */
    public function setPrefix(string $prefix): void
    {
        $this->update(['prefix' => $prefix]);
    }

    /**
     * Получить позицию заметки
     *
     * @return int Позиция заметки
     */
    public function getNotePosition(): int
    {
        return $this->data['notePosition'];
    }

    /**
     * Установить позицию заметки
     *
     * @param int $position Новая позиция
     * @throws Exception
     */
    public function setNotePosition(int $position): void
    {
        $this->update(['notePosition' => $position]);
    }

    /**
     * Проверить, раскрыта ли ветка
     *
     * @return bool True если ветка раскрыта
     */
    public function isExpanded(): bool
    {
        return $this->data['isExpanded'];
    }

    /**
     * Установить, раскрыта ли ветка
     *
     * @param bool $expanded Раскрыть или свернуть ветку
     * @throws Exception
     */
    public function setExpanded(bool $expanded): void
    {
        $this->update(['isExpanded' => $expanded]);
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
     * Получить объект родительской заметки
     *
     * @return Note Объект родительской заметки
     * @throws Exception
     */
    public function getParentNote(): Note
    {
        return $this->trilium->getNoteById($this->getParentNoteId());
    }

    /**
     * Удалить ветку
     *
     * @throws Exception
     */
    public function delete(): void
    {
        $this->trilium->request('DELETE', "/branches/{$this->getId()}", null, 204);
    }

    /**
     * Обновить данные ветки
     *
     * @param array $data Данные для обновления
     * @throws Exception
     */
    private function update(array $data): void
    {
        $this->data = $this->trilium->request('PATCH', "/branches/{$this->getId()}", $data);
    }
}
