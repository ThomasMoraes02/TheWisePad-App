<?php 
namespace TheWisePad\Application\UseCases\Authentication;

interface TokenManager
{
    public function sigIn($payload, $expires = null): string;

    public function verify(string $token): bool;
}