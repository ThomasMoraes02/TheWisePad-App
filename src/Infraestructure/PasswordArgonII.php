<?php 
namespace TheWisePad\Infraestructure;

use TheWisePad\Domain\PasswordEncoded;

class PasswordArgonII implements PasswordEncoded
{
    private $password;

    public function __construct(string $password = null)
    {
        if(!is_null($password)) {
            $this->password = $this->encoded($password);
        }
    }

    public function encoded(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }

    public function verify(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }

    public function __toString()
    {
        return $this->password;
    }
}