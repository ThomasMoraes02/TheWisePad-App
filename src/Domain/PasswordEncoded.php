<?php 
namespace TheWisePad\Domain;

interface PasswordEncoded
{
    public function encoded(string $password): string;

    public function verify(string $password, string $passwordHash): bool;
}