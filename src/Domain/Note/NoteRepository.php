<?php 
namespace TheWisePad\Domain\Note;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;

interface NoteRepository
{
    public function addNote(Note $note);

    public function findById(string $id): Note;

    public function updateTitle(string $id, string $title): void;

    public function updateContent(string $id, string $content): void;

    public function removeNote(string $id): void;

    public function findAllNotesFrom(Email $email, int $page = 0, int $per_page = 0): array;
}