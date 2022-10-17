<?php 
namespace TheWisePad\Infraestructure;

use TheWisePad\Application\UseCases\Authentication\TokenManager;

class TokenUniqId implements TokenManager
{
    public function sigIn(): string
    {
        return uniqid("auth-" . md5(rand()), true);
    }
}