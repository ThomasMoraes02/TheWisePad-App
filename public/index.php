<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use TheWisePad\Application\Factories\MakeLoadNoteController;
use TheWisePad\Application\Factories\MakeAuthenticateMiddleware;
use TheWisePad\Application\Factories\MakeCreateNoteController;
use TheWisePad\Application\Factories\MakeRemoveNoteController;
use TheWisePad\Application\Factories\MakeUpdateNoteController;

require_once __DIR__ . "/../vendor/autoload.php";

$app = AppFactory::create();

$app->setBasePath(BASE_PATH);

// $app->addErrorMiddleware(true, true, true);

$app->post("/signup", "TheWisePad\Application\Factories\MakeSignUp");

$app->group('/', function(RouteCollectorProxy $group) {

    $group->get('notes/{email}', new MakeLoadNoteController);

    $group->post('notes', new MakeCreateNoteController);

    $group->put('notes/{id}', new MakeUpdateNoteController);

    $group->delete('notes/{id}', new MakeRemoveNoteController);

})->add(new MakeAuthenticateMiddleware($app));

$app->run();