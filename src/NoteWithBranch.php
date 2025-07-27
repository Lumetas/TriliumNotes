<?php
namespace Lumetas\TriliumNotes;
class NoteWithBranch
{
    private Note $note;
    private Branch $branch;

    public function __construct(Note $note, Branch $branch)
    {
        $this->note = $note;
        $this->branch = $branch;
    }

    /**
     * Получить объект заметки
     *
     * @return Note Объект заметки
     */
    public function getNote(): Note
    {
        return $this->note;
    }

    /**
     * Получить объект ветки
     *
     * @return Branch Объект ветки
     */
    public function getBranch(): Branch
    {
        return $this->branch;
    }
}
