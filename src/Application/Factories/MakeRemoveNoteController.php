<?php 
namespace TheWisePad\Application\Factories;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Application\RemoveNoteOperation;
use TheWisePad\Application\UseCases\RemoveNote;
use TheWisePad\Application\Factories\HelperFactorie;
use TheWisePad\Application\Factories\ControllerFactory;

class MakeRemoveNoteController
{
    use HelperFactorie;

    protected $controller;

    public function __construct()
    {
        $userRepository = $this->getInstance(USER_REPOSITORY);
        $noteRepository = $this->getInstance(NOTE_REPOSITORY);

        $useCase = new RemoveNote($noteRepository, $userRepository);
        $this->controller = new WebController(new RemoveNoteOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload['id'] = $args['id'];
        $responseController = $this->controller->handle($payload);

        return $this->adapteRoute($response, $responseController);
    }
}