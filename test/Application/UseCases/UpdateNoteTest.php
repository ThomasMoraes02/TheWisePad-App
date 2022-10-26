<?php 
namespace TheWisePad\Test\Application\UseCases;

use PHPUnit\Framework\TestCase;
use TheWisePad\Application\UseCases\UpdateNote;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\Note\NoteRepositoryMemory;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class UpdateNoteTest extends TestCase
{
    private $userRepository;

    private $noteRepository;

    protected function setUp()
    {
        $user = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));
        $this->userRepository = new UserRepositoryMemory();
        $this->userRepository->addUser($user);

        $note = new Note($user, "first title", "first content");
        $this->noteRepository = new NoteRepositoryMemory();
        $this->noteRepository->addNote($note);
    }

    public function test_update_note()
    {
        $updateNote = new UpdateNote($this->noteRepository, $this->userRepository);

        $request = [
            'email' => 'thomas@gmail.com',
            'id' => 0,
            'title' => 'New title note',
            'content' => ''
        ];

        $response = $updateNote->perform($request);
        
        $this->assertEquals("New title note", $response['title']);
    }
}