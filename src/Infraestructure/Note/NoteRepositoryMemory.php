<?php
namespace TheWisePad\Infraestructure\Note;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\Note\NoteRepository;
use TheWisePad\Domain\Exceptions\NoteNotFound;

class NoteRepositoryMemory implements NoteRepository
{
    private $notes = [];

    public function addNote(Note $note): void
    {
        $this->notes[] = $note;
    }

    public function findById(string $id): Note
    {
        $note = $this->filterbyId($id);
        return $note;
    }

    public function updateTitle(string $id, string $title): void
    {
        $note = $this->filterbyId($id);
        $note->setTitle($title);
    }

    public function updateContent(string $id, string $content): void
    {
        $note = $this->filterbyId($id);
        $note->setContent($content);
    }

    public function removeNote(string $id): void
    {
        $this->filterbyId($id);
        unset($this->notes[$id]);
    }

    public function findAllNotesFrom(Email $email): array
    {
        $findNotes = [];
        $findNotes = array_filter($this->notes, function($note) use ($email) {
            if($note->getUser()->getEmail() == $email) {
                return $note;
            }
        });

        return $findNotes;
    }

    private function filterbyId(string $id)
    {
        $findNote = array_filter($this->notes, function($note) use ($id) {
            return $note == $id;
        }, ARRAY_FILTER_USE_KEY);

        if(empty($findNote)) {
            throw new NoteNotFound();
        }

        $note = current($findNote);
        return $note;
    }
}