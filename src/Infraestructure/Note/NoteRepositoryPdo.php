<?php 
namespace TheWisePad\Infraestructure\Note;

use PDO;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\Note\NoteRepository;
use TheWisePad\Infraestructure\ConnectionPdo;
use TheWisePad\Domain\Exceptions\NoteNotFound;
use TheWisePad\Infraestructure\User\UserRepositoryPdo;

class NoteRepositoryPdo implements NoteRepository
{
    private $pdo;

    public function __construct()
    {
        $pdo = new ConnectionPdo();
        $this->pdo = $pdo->getConnection();
    }

    public function addNote(Note $note): Note
    {
        $query = "INSERT INTO note (title, content, email) VALUES (:title, :content, :email)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":title", $note->getTitle());
        $stmt->bindParam(":content", $note->getContent());
        $stmt->bindParam(":email", $note->getUser()->getEmail());

        $statusNote = $stmt->execute();

        if($statusNote) {
            return $note;
        }
    }

    public function findById(string $id): Note
    {
        $query = "SELECT * FROM note WHERE note_id = '$id'";
        $note = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
        
        $note = current($note);

        if(empty($note)) {
            throw new NoteNotFound("Not with id: $id not found.");
        }

        $userRepository = USER_REPOSITORY;
        $userRepository = new $userRepository();
        $user = $userRepository->findByEmail(new Email($note['email']));
        
        return new Note($user, $note['title'], $note['content']);   
    }

    public function updateTitle(string $id, string $title): void
    {
        $query = "UPDATE note SET title = '$title' WHERE note_id = '$id'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function updateContent(string $id, string $content): void
    {
        $query = "UPDATE note SET content = '$content' WHERE note_id = '$id'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function removeNote(string $id): void
    {
        $query = "DELETE FROM note WHERE note_id = '$id'";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
    }

    public function findAllNotesFrom(Email $email): array
    {
        $query = "SELECT * FROM note WHERE email = '$email'";
        $notes = $this->pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return $notes;
    }
}