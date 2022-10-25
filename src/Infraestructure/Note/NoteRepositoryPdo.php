<?php 
namespace TheWisePad\Infraestructure\Note;

use PDO;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\Note\NoteRepository;
use TheWisePad\Infraestructure\ConnectionPdo;
use TheWisePad\Domain\Exceptions\NoteNotFound;

class NoteRepositoryPdo implements NoteRepository
{
    private $pdo;

    public function __construct()
    {
        $pdo = new ConnectionPdo();
        $this->pdo = $pdo->getConnection();
    }

    public function addNote(Note $note): void
    {
        $query = "INSERT INTO note VALUES (:title, :content: :user)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":title", $note->getTitle());
        $stmt->bindParam(":content", $note->getContent());
        $stmt->bindParam(":user", $note->getUser());

        $stmt->execute();
    }

    public function findById(string $id): Note
    {
        $query = "SELECT * FROM note WHERE id = '$id'";
        $note = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        
        $note = current($note);

        return new Note($note['user'], $note['title'], $note['content']);
    }

    public function updateTitle(string $id, string $title): void
    {
        $query = "UPDATE note SET title = '$title' WHERE id = '$id'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function updateContent(string $id, string $content): void
    {
        $query = "UPDATE note SET content = '$content' WHERE id = '$id'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function removeNote(string $id): void
    {
        $query = "DELETE FROM note WHERE id = '$id'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function findAllNotesFrom(Email $email): array
    {
        $query = "SELECT * FROM note";
        $notes = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        $allNotes = [];
        foreach($notes as $note) {
            if($note['user']->getEmail() == $email) {
                $allNotes[] = $note;
            }   
        }

        return $allNotes;
    }
}