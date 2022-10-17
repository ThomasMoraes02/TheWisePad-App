<?php 
namespace TheWisePad\Application\UseCases\Authentication;

interface TokenManager
{
    public function sigIn(): string;
}