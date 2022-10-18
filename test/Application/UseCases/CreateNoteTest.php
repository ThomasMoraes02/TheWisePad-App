<?php 
namespace TheWisePad\Test\Application\UseCases;

use PHPUnit\Framework\TestCase;
use TheWisePad\Application\UseCases\CreateNote;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\Note\NoteRepositoryMemory;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class CreateNoteTest extends TestCase
{
    private $userRepository;

    private $noteRepository;

    private $user;

    public function setUp()
    {
        $this->userRepository = new UserRepositoryMemory();
        $this->noteRepository = new NoteRepositoryMemory();

        $this->user = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));
        $this->userRepository->addUser($this->user);
    }

    public function test_create_note()
    {
        $note = new CreateNote($this->noteRepository, $this->userRepository);

        $request = [
            'email' => 'thomas@gmail.com',
            'title' => 'Note title',
            'content' => 'Note content'
        ];

        $note->perform($request);

        $AllNotesFromThom = $this->noteRepository->findAllNotesFrom($this->user->getEmail());

        $this->assertEquals(1, count($AllNotesFromThom));
        $this->assertEquals('Note title', $AllNotesFromThom[0]->getTitle());
    }
}