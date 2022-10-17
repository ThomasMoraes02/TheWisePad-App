<?php 
namespace TheWisePad\Test\Infraestructure\User;

use PHPUnit\Framework\TestCase;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\Exceptions\UserNotFound;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class UserRepositoryMemoryTest extends TestCase
{
    public function test_add_user_repository()
    {
        $user = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));
        
        $repository = new UserRepositoryMemory();
        $repository->addUser($user);

        $findUser = $repository->findByEmail(new Email("thomas@gmail.com"));

        $this->assertEquals("Thomas", $findUser->getName());
    }

    public function test_find_all()
    {
        $user1 = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));
        $user2 = User::create("Igor", "igor@gmail.com", new PasswordArgonII("987654"));

        $repository = new UserRepositoryMemory();
        $repository->addUser($user1);
        $repository->addUser($user2);

        $this->assertEquals(2, count($repository->findAll()));
    }

    public function test_user_not_found()
    {
        $this->expectException(UserNotFound::class);

        $repository = new UserRepositoryMemory();
        $repository->findByEmail(new Email("thomas@gmail.com"));
    }
}