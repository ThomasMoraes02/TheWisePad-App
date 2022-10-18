<?php 
namespace TheWisePad\Application\Factories;

use TheWisePad\Application\CreateNoteOperation;
use TheWisePad\Application\UseCases\CreateNote;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Infraestructure\Note\NoteRepositoryMemory;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class makeCreateNoteController
{
    public function __construct()
    {
        $userRepository = new UserRepositoryMemory();
        $noteRepository = new NoteRepositoryMemory();

        $useCase = new CreateNote($noteRepository, $userRepository);
        $controller = new WebController(new CreateNoteOperation($useCase));
        
        return $controller;
    }
}