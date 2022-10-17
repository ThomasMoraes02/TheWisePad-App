<?php 
namespace TheWisePad\Application\UseCases;

interface UseCase
{
    public function perform(array $request): array;
}