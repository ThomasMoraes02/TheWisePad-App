<?php 
namespace TheWisePad\Application\Factories;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use TheWisePad\Application\SignUpOperation;
use TheWisePad\Application\UseCases\SignUp;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Application\Factories\HelperFactorie;
use TheWisePad\Application\Factories\ControllerFactory;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;

class MakeSignUp
{
    use HelperFactorie;

    protected $controller;

    public function __construct()
    {
        $userRepository = $this->getInstance(USER_REPOSITORY);
        $encoder = $this->getInstance(ENCODER);
        $tokenManager = $this->getInstance(TOKEN_MANAGER);

        $authenticationService = new CustomAuthentication($userRepository, $encoder, $tokenManager);
        $useCase = new SignUp($userRepository, $encoder, $authenticationService);

        $this->controller = new WebController(new SignUpOperation($useCase));
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $payload = $request->getParsedBody();
        $responseController = $this->controller->handle($payload);

        return $this->adapteRoute($response, $responseController);
    }
}