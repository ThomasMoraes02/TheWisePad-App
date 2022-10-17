<?php 
namespace TheWisePad\Domain\User;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\User\User;

interface UserRepository
{
    public function addUser(User $user): void;

    public function findByEmail(Email $email): User;

    public function findAll(): array;
}