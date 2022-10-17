<?php 
namespace TheWisePad\Infraestructure\User;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\User\User;
use TheWisePad\Domain\User\UserRepository;
use TheWisePad\Domain\Exceptions\UserNotFound;

class UserRepositoryMemory implements UserRepository
{
    private $users = [];

    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    public function findByEmail(Email $email): User
    {
        $userFind = array_filter($this->users, function($user) use ($email) {
            if($user->getEmail() == $email) {
                return $user;
            }
        });

        if(empty($userFind)) {
            throw new UserNotFound($email);
        }

        return current($userFind);
    }

    public function findAll(): array
    {
        return $this->users;
    }
}