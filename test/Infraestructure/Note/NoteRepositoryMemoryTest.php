<?php 
namespace TheWisePad\Test\Infraestructure\Note;

use TheWisePad\Domain\Email;
use PHPUnit\Framework\TestCase;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\User\User;
use TheWisePad\Domain\Exceptions\NoteNotFound;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\Note\NoteRepositoryMemory;

class NoteRepositoryMemoryTest extends TestCase
{
    private $repository;
    private $user;

    protected function setUp()
    {
        $this->user = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));
        $this->repository = new NoteRepositoryMemory();
    }

    public function test_add_note()
    {
        $note = new Note($this->user, "Title 1", "Content 1");

        $this->repository->addNote($note);

        $findNote = $this->repository->findById(0);

        $this->assertEquals("Title 1", $findNote->getTitle());
    }

    public function test_update_title_and_content()
    {
        $note = new Note($this->user, "title 1", "content 1");
        
        $this->repository->addNote($note);

        $this->repository->updateTitle(0, "new title");
        $this->repository->updateContent(0, "new content");

        $note = $this->repository->findById(0);

        $this->assertEquals("new title", $note->getTitle());
        $this->assertEquals("new content", $note->getContent());
    }

    public function test_remove_note()
    {
        $this->expectException(NoteNotFound::class);

        $note = new Note($this->user, "title 1", "content 1");

        $this->repository->addNote($note);
        $this->repository->removeNote(0);

        $this->repository->findById(0);
    }

    public function test_find_all_from()
    {
        $note1 = new Note($this->user, "title 1", "content 1");
        $note2 = new Note($this->user, "title 2", "content 2");

        $this->repository->addNote($note1);
        $this->repository->addNote($note2);

        $allNotesFromThomas = $this->repository->findAllNotesFrom($this->user->getEmail());

        $this->assertEquals(2, count($allNotesFromThomas));
    }
}