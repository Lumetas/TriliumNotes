<?php
namespace Lumetas\TriliumNotes;
class Attachment
{
    private Trilium $trilium;
    private array $data;

    public function __construct(Trilium $trilium, array $data)
    {
        $this->trilium = $trilium;
        $this->data = $data;
    }

    /**
     * Получить ID вложения
     *
     * @return string ID вложения
     */
    public function getId(): string
    {
        return $this->data['attachmentId'];
    }

    /**
     * Получить ID владельца (заметки или ревизии)
     *
     * @return string ID владельца
     */
    public function getOwnerId(): string
    {
        return $this->data['ownerId'];
    }

    /**
     * Получить роль вложения
     *
     * @return string Роль вложения
     */
    public function getRole(): string
    {
        return $this->data['role'];
    }

    /**
     * Установить новую роль вложения
     *
     * @param string $role Новая роль
     * @throws Exception
     */
    public function setRole(string $role): void
    {
        $this->update(['role' => $role]);
    }

    /**
     * Получить MIME-тип вложения
     *
     * @return string MIME-тип
     */
    public function getMime(): string
    {
        return $this->data['mime'];
    }

    /**
     * Установить новый MIME-тип вложения
     *
     * @param string $mime Новый MIME-тип
     * @throws Exception
     */
    public function setMime(string $mime): void
    {
        $this->update(['mime' => $mime]);
    }

    /**
     * Получить заголовок вложения
     *
     * @return string Заголовок вложения
     */
    public function getTitle(): string
    {
        return $this->data['title'];
    }

    /**
     * Установить новый заголовок вложения
     *
     * @param string $title Новый заголовок
     * @throws Exception
     */
    public function setTitle(string $title): void
    {
        $this->update(['title' => $title]);
    }

    /**
     * Получить позицию вложения
     *
     * @return int Позиция вложения
     */
    public function getPosition(): int
    {
        return $this->data['position'];
    }

    /**
     * Установить новую позицию вложения
     *
     * @param int $position Новая позиция
     * @throws Exception
     */
    public function setPosition(int $position): void
    {
        $this->update(['position' => $position]);
    }

    /**
     * Получить ID blob-объекта (хеш содержимого)
     *
     * @return string ID blob-объекта
     */
    public function getBlobId(): string
    {
        return $this->data['blobId'];
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
     * Получить дату изменения в UTC
     *
     * @return string Дата изменения в формате "YYYY-MM-DD HH:MM:SS.SSSZ"
     */
    public function getUtcDateModified(): string
    {
        return $this->data['utcDateModified'];
    }

    /**
     * Получить дату планируемого удаления в UTC
     *
     * @return string|null Дата в формате "YYYY-MM-DD HH:MM:SS.SSSZ" или null если не установлено
     */
    public function getUtcDateScheduledForErasureSince(): ?string
    {
        return $this->data['utcDateScheduledForErasureSince'] ?? null;
    }

    /**
     * Получить длину содержимого вложения
     *
     * @return int Длина содержимого в байтах
     */
    public function getContentLength(): int
    {
        return $this->data['contentLength'];
    }

    /**
     * Получить содержимое вложения
     *
     * @return string Содержимое вложения
     * @throws Exception
     */
    public function getContent(): string
    {
        return $this->trilium->requestRaw('GET', "/attachments/{$this->getId()}/content", null, 200);
    }

    /**
     * Записать новое содержимое вложения
     *
     * @param string $content Новое содержимое
     * @throws Exception
     */
    public function writeContent(string $content): void
    {
        $this->trilium->request('PUT', "/attachments/{$this->getId()}/content", $content, 204);
    }

    /**
     * Получить объект владельца (заметки)
     *
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getOwner(): Note
    {
        return $this->trilium->getNoteById($this->getOwnerId());
    }

    /**
     * Удалить вложение
     *
     * @throws Exception
     */
    public function delete(): void
    {
        $this->trilium->request('DELETE', "/attachments/{$this->getId()}", null, 204);
    }

    /**
     * Обновить данные вложения
     *
     * @param array $data Данные для обновления
     * @throws Exception
     */
    private function update(array $data): void
    {
        $this->data = $this->trilium->request('PATCH', "/attachments/{$this->getId()}", $data);
    }
}
