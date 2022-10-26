<?php 
namespace TheWisePad\Application\Factories;

use Slim\Psr7\Response;

Trait HelperFactorie
{
    public function adapteRoute($response, $responseController): Response
    {
        $response->getBody()->write(json_encode($responseController['body'], JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($responseController['statusCode']);
    }

    public function getInstance($constant): object
    {
        $instance = $constant;
        $instance = new $instance();
        return $instance;
    }
}