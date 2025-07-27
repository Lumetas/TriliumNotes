<?php
namespace Lumetas\TriliumNotes;
class Trilium
{
    private string $endpoint;
    private string $authToken;

    /**
     * Конструктор Trilium ETAPI клиента
     *
     * @param string $endpoint Базовый URL ETAPI (например, "http://localhost:37740/etapi")
     * @param string $authToken Токен аутентификации ETAPI
     */
    public function __construct(string $endpoint, string $authToken)
    {
        $this->endpoint = rtrim($endpoint, '/');
        $this->authToken = $authToken;
    }

    /**
     * Получить информацию о приложении Trilium
     *
     * @return array Массив с информацией о приложении
     * @throws Exception
     */
    public function getAppInfo(): array
    {
        return $this->request('GET', '/app-info');
    }

    /**
     * Создать резервную копию базы данных
     *
     * @param string $backupName Имя резервной копии (будет использовано в имени файла)
     * @throws Exception
     */
    public function createBackup(string $backupName): void
    {
        $this->request('PUT', "/backup/$backupName", null, 204);
    }

    /**
     * Получить заметку по ID
     *
     * @param string $noteId ID заметки
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getNoteById(string $noteId): Note
    {
        $data = $this->request('GET', "/notes/$noteId");
        return new Note($this, $data);
    }

    /**
     * Поиск заметок через Generator
     *
     * @param string $searchQuery Строка поиска
     * @param array $options Дополнительные параметры поиска:
     *   - fastSearch: bool - быстрый поиск (не ищет в содержимом)
     *   - includeArchivedNotes: bool - включать архивированные заметки
     *   - ancestorNoteId: string - искать только в поддереве
     *   - ancestorDepth: string - глубина поиска (eq1, eq3, lt4, gt4 и т.д.)
     *   - orderBy: string - поле для сортировки
     *   - orderDirection: string - направление сортировки (asc/desc)
     *   - limit: int - ограничение количества результатов
     * @return Generator|Note[] Генератор объектов Note
     * @throws Exception
     */
    public function forSearchNotes(string $searchQuery, array $options = []): \Generator
    {
        $params = ['search' => $searchQuery] + $options;
        $data = $this->request('GET', '/notes', $params);
        
        foreach ($data['results'] as $noteData) {
            yield new Note($this, $noteData);
        }
    }

    /**
     * Поиск заметок через
     *
     * @param string $searchQuery Строка поиска
     * @param array $options Дополнительные параметры поиска:
     *   - fastSearch: bool - быстрый поиск (не ищет в содержимом)
     *   - includeArchivedNotes: bool - включать архивированные заметки
     *   - ancestorNoteId: string - искать только в поддереве
     *   - ancestorDepth: string - глубина поиска (eq1, eq3, lt4, gt4 и т.д.)
     *   - orderBy: string - поле для сортировки
     *   - orderDirection: string - направление сортировки (asc/desc)
     *   - limit: int - ограничение количества результатов
     * @return array|Note[] Генератор объектов Note
     * @throws Exception
     */
    public function searchNotes(string $searchQuery, array $options = []): array
    {
        $params = ['search' => $searchQuery] + $options;
        $data = $this->request('GET', '/notes', $params);

		$notes = [];

        foreach ($data['results'] as $noteData) {
            $notes[] = new Note($this, $noteData);
        }

		return $notes;
    }

    /**
     * Создать новую заметку
     *
     * @param string $parentNoteId ID родительской заметки
     * @param string $title Заголовок заметки
     * @param string $type Тип заметки (text, code, file, image и т.д.)
     * @param string $content Содержимое заметки
     * @param array $options Дополнительные параметры:
     *   - mime: string - MIME-тип (для типов code, file, image)
     *   - notePosition: int - позиция заметки
     *   - prefix: string - префикс заголовка
     *   - isExpanded: bool - раскрыта ли папка
     * @return NoteWithBranch Объект созданной заметки с информацией о ветке
     * @throws Exception
     */
    public function createNote(string $parentNoteId, string $title, string $type, string $content, array $options = []): NoteWithBranch
    {
        $data = [
            'parentNoteId' => $parentNoteId,
            'title' => $title,
            'type' => $type,
            'content' => $content,
        ] + $options;

        $response = $this->request('POST', '/create-note', $data, 201);
        return new NoteWithBranch(
            new Note($this, $response['note']),
            new Branch($this, $response['branch'])
        );
    }

    /**
     * Получить заметку "входящие" для указанной даты
     *
     * @param string $date Дата в формате YYYY-MM-DD
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getInboxNote(string $date): Note
    {
        $data = $this->request('GET', "/inbox/$date");
        return new Note($this, $data);
    }

    /**
     * Получить дневную заметку для указанной даты
     *
     * @param string $date Дата в формате YYYY-MM-DD
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getDayNote(string $date): Note
    {
        $data = $this->request('GET', "/calendar/days/$date");
        return new Note($this, $data);
    }

    /**
     * Получить недельную заметку для указанной даты
     *
     * @param string $date Дата в формате YYYY-MM-DD
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getWeekNote(string $date): Note
    {
        $data = $this->request('GET', "/calendar/weeks/$date");
        return new Note($this, $data);
    }

    /**
     * Получить месячную заметку для указанного месяца
     *
     * @param string $month Месяц в формате YYYY-MM
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getMonthNote(string $month): Note
    {
        $data = $this->request('GET', "/calendar/months/$month");
        return new Note($this, $data);
    }

    /**
     * Получить годовую заметку для указанного года
     *
     * @param string $year Год в формате YYYY
     * @return Note Объект заметки
     * @throws Exception
     */
    public function getYearNote(string $year): Note
    {
        $data = $this->request('GET', "/calendar/years/$year");
        return new Note($this, $data);
    }

    /**
     * Создать ветку (связь между заметками)
     *
     * @param string $parentNoteId ID родительской заметки
     * @param string $noteId ID дочерней заметки
     * @param array $options Дополнительные параметры:
     *   - prefix: string - префикс заголовка
     *   - notePosition: int - позиция заметки
     *   - isExpanded: bool - раскрыта ли папка
     * @return Branch Объект созданной ветки
     * @throws Exception
     */
    public function createBranch(string $parentNoteId, string $noteId, array $options = []): Branch
    {
        $data = [
            'parentNoteId' => $parentNoteId,
            'noteId' => $noteId,
        ] + $options;

        $response = $this->request('POST', '/branches', $data, [200, 201]);
        return new Branch($this, $response);
    }

    /**
     * Получить ветку по ID
     *
     * @param string $branchId ID ветки
     * @return Branch Объект ветки
     * @throws Exception
     */
    public function getBranchById(string $branchId): Branch
    {
        $data = $this->request('GET', "/branches/$branchId");
        return new Branch($this, $data);
    }

    /**
     * Создать атрибут (метку или отношение)
     *
     * @param string $noteId ID заметки
     * @param string $type Тип атрибута (label или relation)
     * @param string $name Имя атрибута
     * @param string|null $value Значение атрибута (опционально)
     * @param array $options Дополнительные параметры:
     *   - position: int - позиция атрибута
     *   - isInheritable: bool - наследуемый ли атрибут
     * @return Attribute Объект атрибута
     * @throws Exception
     */
    public function createAttribute(string $noteId, string $type, string $name, ?string $value = null, array $options = []): Attribute
    {
        $data = [
            'noteId' => $noteId,
            'type' => $type,
            'name' => $name,
            'value' => $value,
        ] + $options;

        $response = $this->request('POST', '/attributes', $data, 201);
        return new Attribute($this, $response);
    }

    /**
     * Получить атрибут по ID
     *
     * @param string $attributeId ID атрибута
     * @return Attribute Объект атрибута
     * @throws Exception
     */
    public function getAttributeById(string $attributeId): Attribute
    {
        $data = $this->request('GET', "/attributes/$attributeId");
        return new Attribute($this, $data);
    }

    /**
     * Создать вложение
     *
     * @param string $ownerId ID владельца (заметки или ревизии)
     * @param string $role Роль вложения
     * @param string $mime MIME-тип
     * @param string $title Заголовок вложения
     * @param string $content Содержимое вложения
     * @param int|null $position Позиция вложения
     * @return Attachment Объект вложения
     * @throws Exception
     */
    public function createAttachment(string $ownerId, string $role, string $mime, string $title, string $content, ?int $position = null): Attachment
    {
        $data = [
            'ownerId' => $ownerId,
            'role' => $role,
            'mime' => $mime,
            'title' => $title,
            'content' => $content,
        ];

        if ($position !== null) {
            $data['position'] = $position;
        }

        $response = $this->request('POST', '/attachments', $data, 201);
        return new Attachment($this, $response);
    }

    /**
     * Получить вложение по ID
     *
     * @param string $attachmentId ID вложения
     * @return Attachment Объект вложения
     * @throws Exception
     */
    public function getAttachmentById(string $attachmentId): Attachment
    {
        $data = $this->request('GET', "/attachments/$attachmentId");
        return new Attachment($this, $data);
    }

    /**
     * Обновить порядок заметок для родительской заметки
     *
     * @param string $parentNoteId ID родительской заметки
     * @throws Exception
     */
    public function refreshNoteOrdering(string $parentNoteId): void
    {
        $this->request('POST', "/refresh-note-ordering/$parentNoteId", null, 204);
    }

    /**
     * Выполнить HTTP-запрос к ETAPI
     *
     * @param string $method HTTP-метод (GET, POST, PUT, PATCH, DELETE)
     * @param string $path Путь API
     * @param mixed $data Данные для отправки
     * @param int|array $expectedStatus Ожидаемый HTTP-статус ответа
     * @return array Данные ответа
     * @throws Exception
     */
    public function request(string $method, string $path, $data = null, $expectedStatus = 200): array
    {
        $url = $this->endpoint . $path;
        
        if ($method === 'GET' && $data) {
            $url .= '?' . http_build_query($data);
            $data = null;
        }

        $headers = [
            'Authorization: ' . $this->authToken,
            'Accept: application/json',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data !== null) {
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($jsonData);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!is_array($expectedStatus)) {
            $expectedStatus = [$expectedStatus];
        }

        if (!in_array($status, $expectedStatus)) {
            $errorData = json_decode($response, true) ?? ['message' => $response];
            throw new Exception(
                "ETAPI request failed: " . $response,
                $status
            );
        }

        if ($status === 204) {
            return [];
        }

        return json_decode($response, true) ?? [];
    }

    /**
     * Выполнить HTTP-запрос к ETAPI и получить сырое тело
     *
     * @param string $method HTTP-метод (GET, POST, PUT, PATCH, DELETE)
     * @param string $path Путь API
     * @param mixed $data Данные для отправки
     * @param int|array $expectedStatus Ожидаемый HTTP-статус ответа
     * @return string Данные ответа
     * @throws Exception
     */
    public function requestRaw(string $method, string $path, $data = null, $expectedStatus = 200, array $customHeaders = []): string
    {
        $url = $this->endpoint . $path;
        
        if ($method === 'GET' && $data) {
            $url .= '?' . http_build_query($data);
            $data = null;
        }

        $headers = [
            'Authorization: ' . $this->authToken,
            'Accept: application/json',
        ];

		$headers = array_merge($headers, $customHeaders);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Content-Length: ' . strlen($data);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!is_array($expectedStatus)) {
            $expectedStatus = [$expectedStatus];
        }

        if (!in_array($status, $expectedStatus)) {
            $errorData = json_decode($response, true) ?? ['message' => $response];
            throw new Exception(
                "ETAPI request failed: " . $response,
                $status
            );
        }

        if ($status === 204) {
            return '';
        }

        return $response;
    }
}
