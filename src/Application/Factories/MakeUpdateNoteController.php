<?php 
namespace TheWisePad\Application\Factories;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Application\UpdateNoteOperation;
use TheWisePad\Application\UseCases\UpdateNote;
use TheWisePad\Application\Factories\HelperFactorie;
use TheWisePad\Application\Factories\ControllerFactory;

class MakeUpdateNoteController
{
    use HelperFactorie;

    protected $controller;

    public function __construct()
    {
        $userRepository = $this->getInstance(USER_REPOSITORY);
        $noteRepository = $this->getInstance(NOTE_REPOSITORY);

        $useCase = new UpdateNote($noteRepository, $userRepository);
        $this->controller = new WebController(new UpdateNoteOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        parse_str($request->getBody()->getContents(), $payload);
        $payload['id'] = $args['id'];

        $responseController = $this->controller->handle($payload);

        return $this->adapteRoute($response, $responseController);
    }
}