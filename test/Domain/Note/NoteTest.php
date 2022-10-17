<?php 
namespace TheWisePad\Test\Domain\Note;

use PHPUnit\Framework\TestCase;
use TheWisePad\Domain\Note\Note;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\PasswordArgonII;

class NoteTest extends TestCase
{
    public function test_create_note()
    {
        $user = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));

        $note = new Note($user, "Primeiro titulo", "Primeiro Conteudo");

        $this->assertEquals("Primeiro titulo", $note->getTitle());
        $this->assertEquals("Thomas", $note->getUser()->getName());
    }
}