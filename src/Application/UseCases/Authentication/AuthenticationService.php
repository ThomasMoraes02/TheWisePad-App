<?php 
namespace TheWisePad\Application\UseCases\Authentication;

interface AuthenticationService
{
    public function auth(array $authenticationParams): array;
}