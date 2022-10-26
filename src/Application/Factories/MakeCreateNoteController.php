<?php 
namespace TheWisePad\Application\Factories;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Application\CreateNoteOperation;
use TheWisePad\Application\UseCases\CreateNote;
use TheWisePad\Application\Factories\HelperFactorie;

class MakeCreateNoteController
{
    use HelperFactorie;

    protected $controller;

    public function __construct()
    {
        $userRepository = $this->getInstance(USER_REPOSITORY);
        $noteRepository = $this->getInstance(NOTE_REPOSITORY);

        $useCase = new CreateNote($noteRepository, $userRepository);
        $this->controller = new WebController(new CreateNoteOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload = $request->getParsedBody();
        $responseController = $this->controller->handle($payload);

        return $this->adapteRoute($response, $responseController);
    }
}