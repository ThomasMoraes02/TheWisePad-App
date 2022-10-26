<?php 
namespace TheWisePad\Application\Factories;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheWisePad\Application\LoadNoteOperation;
use TheWisePad\Application\UseCases\LoadNote;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Application\Factories\HelperFactorie;

class MakeLoadNoteController
{
    use HelperFactorie;

    protected $controller;

    public function __construct()
    {
        $noteRepository = $this->getInstance(NOTE_REPOSITORY);

        $useCase = new LoadNote($noteRepository);
        $this->controller = new WebController(new LoadNoteOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload['email'] = $args['email'];
        $responseController = $this->controller->handle($payload);

        return $this->adapteRoute($response, $responseController);
    }
}