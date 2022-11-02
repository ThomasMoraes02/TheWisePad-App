<?php 
namespace TheWisePad\Infraestructure\Note;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\Note\Note;
use MongoDB\Operation\FindOneAndUpdate;
use SebastianBergmann\Environment\Console;
use TheWisePad\Domain\Note\NoteRepository;
use TheWisePad\Domain\Exceptions\NoteNotFound;
use TheWisePad\Infraestructure\ConnectionManager;

class NoteRepositoryMongodb implements NoteRepository
{
    private $mongo;

    private $connection;

    private $collection = "note";

    public function __construct()
    {
        $this->connection = ConnectionManager::connect();
        $this->mongo = $this->connection->selectCollection($this->collection);
    }

    public function addNote(Note $note)
    {
        $id = $this->getNextId();

        $document = [
            "_id" => $id,
            "title" => $note->getTitle(),
            "content" => $note->getContent(),
            "email" => strval($note->getUser()->getEmail())
        ];

        $this->mongo->insertOne($document);
    }

    public function findById(string $id): Note
    {
        $findNote = $this->mongo->find(["_id" => intval($id)])->toArray();
        $findNote = current($findNote);

        if(empty($findNote)) {
            throw new NoteNotFound;
        }

        $userRepository = USER_REPOSITORY;
        $userRepository = new $userRepository();
        $user = $userRepository->findByEmail(new Email($findNote['email']));

        return new Note($user, $findNote['title'], $findNote['content']); 
    }

    public function updateTitle(string $id, string $title): void
    {
        $this->mongo->updateOne(["_id" => intval($id)],[ '$set' => ["title" => $title]]);
    }

    public function updateContent(string $id, string $content): void
    {
        $this->mongo->updateOne(["_id" => intval($id)],[ '$set' => ["content" => $content]]);
    }

    public function removeNote(string $id): void
    {
        $this->mongo->deleteOne(["_id" => intval($id)]);
    }

    public function findAllNotesFrom(Email $email, int $page = 0, int $per_page = 0): array
    {
        $skip = ($page - 1) * $per_page;
        $skip = ($skip < 0) ? 0 : $skip;

        $options = [
            'skip' => $skip,
            'limit' => $per_page
        ];

        $notes = $this->mongo->find(["email" => strval($email)], $options)->toArray();
        return $notes;        
    }
    
    /**
     * Gera um id auto incremento
     *
     * @return int
     */
    private function getNextId(): int
    {
        $collection = $this->connection->selectCollection("counters");

        $result = $collection->findOneAndUpdate(
            ['_id' => 'note_id'],
            ['$inc' => ['seq' => 1]],
            ['upsert' => true, 'projection' => [ 'seq' => 1 ],'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );

        return $result['seq'];
    }
}