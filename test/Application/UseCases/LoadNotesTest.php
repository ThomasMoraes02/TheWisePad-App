<?php 
namespace TheWisePad\Test\Application\UseCases;

use PHPUnit\Framework\TestCase;
use TheWisePad\Domain\User\User;
use TheWisePad\Application\UseCases\CreateNote;
use TheWisePad\Application\UseCases\LoadNote;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\Note\NoteRepositoryMemory;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class LoadNotesTest extends TestCase
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

        $note = new CreateNote($this->noteRepository, $this->userRepository);

        $request = [
            'email' => 'thomas@gmail.com',
            'title' => 'Note title',
            'content' => 'Note content'
        ];

        $note->perform($request);
    }

    public function test_load_notes()
    {
        $loadNotes = new LoadNote($this->noteRepository);

        $request['email'] = 'thomas@gmail.com';

        $response = $loadNotes->perform($request);

        $this->assertEquals('Note content', $response[0]->getContent());
    }
}