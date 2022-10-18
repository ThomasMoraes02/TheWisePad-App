<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use TheWisePad\Application\Factories\makeSignUpController;
use TheWisePad\Application\SignUpOperation;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;
use TheWisePad\Application\UseCases\SignUp;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\TokenJWT;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

require_once __DIR__ . "/../vendor/autoload.php";

$app = AppFactory::create();

$app->setBasePath('/projetos/thewisepad');

// $app->addErrorMiddleware(true, true, true);

$app->post('/signup', function (Request $request, Response $response, array $args) {
    $payload = $request->getParsedBody();

    $userRepository = new UserRepositoryMemory();
    $tokenManager = new TokenJWT();
    $encoder = new PasswordArgonII();

    $authentication = new CustomAuthentication($userRepository, $encoder, $tokenManager);

    $useCase = new SignUp($userRepository, $encoder, $authentication);

    $signUp = new SignUpOperation($useCase);

    $responseApi = $signUp->specificOp($payload);

    $response->getBody()->write(json_encode($responseApi, JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();