<?php 
namespace TheWisePad\Test\Domain\User;

use TheWisePad\Domain\Email;
use PHPUnit\Framework\TestCase;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\PasswordArgonII;

class UserTest extends TestCase
{
    public function test_create_user()
    {
        $user = new User("Thomas", new Email("thomas@gmail.com"), new PasswordArgonII("123456"));

        $this->assertEquals("Thomas", $user->getName());
    }

    public function test_create_simple_user()
    {
        $user = User::create("thomas", "thomas@gmail.com", new PasswordArgonII("123456"));

        $this->assertEquals("thomas", $user->getName());
    }
}