<?php 
namespace TheWisePad\Domain\User;

use TheWisePad\Domain\Email;
use TheWisePad\Domain\PasswordEncoded;

class User
{
    private $name;

    private $email;

    private $password;

    public function __construct(string $name, Email $email, PasswordEncoded $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(string $name, string $email, PasswordEncoded $password)
    {
        return new User($name, new Email($email), $password);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}