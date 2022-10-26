<?php

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use TheWisePad\Application\Factories\ControllerFactory;

require_once __DIR__ . "/../vendor/autoload.php";

$app = AppFactory::create();

$app->setBasePath(BASE_PATH);

$app->addRoutingMiddleware();

// $app->addErrorMiddleware(true, true, true);
 
$app->post('/signup', function (Request $request, Response $response, array $args) {
    $payload = $request->getParsedBody();

    $signUp = ControllerFactory::makeSignUpController();
    $responseOperation = $signUp->handle($payload);

    $response->getBody()->write(json_encode($responseOperation, JSON_PRETTY_PRINT));
    return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($responseOperation['statusCode']);
});

$app->group('/', function(RouteCollectorProxy $group) {

    $group->get('notes/{email}', function(Request $request, Response $response, array $args) {
        $payload['email'] = $args['email'];

        $loadNotes = ControllerFactory::makeLoadNoteController();
        $responseOperation = $loadNotes->handle($payload);

        $response->getBody()->write(json_encode($responseOperation, JSON_PRETTY_PRINT));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($responseOperation['statusCode']);
    });

    $group->post('notes', function(Request $request, Response $response, array $args) {
        $payload = $request->getParsedBody();

        $creteNote = ControllerFactory::makeCreateNoteController();
        $responseOperation = $creteNote->handle($payload);

        $response->getBody()->write(json_encode($responseOperation, JSON_PRETTY_PRINT));

        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus($responseOperation['statusCode']);
    });

    $group->put('notes', function(Request $request, Response $response, array $args) {
        $response->getBody()->write("Entrei aqui no put");
        return $response->withHeader('Content-Type', 'application/json');    
    });

    $group->delete('notes', function(Request $request, Response $response, array $args) {
        $response->getBody()->write("Entrei aqui no delete");
        return $response->withHeader('Content-Type', 'application/json');    
    });
});

// $app->map(['GET', 'POST'], '/notes', function(Request $request, Response $response, array $args) {

//     $response->getBody()->write("Entrei aqui");
//     return $response->withHeader('Content-Type', 'application/json');
// });

$app->run();