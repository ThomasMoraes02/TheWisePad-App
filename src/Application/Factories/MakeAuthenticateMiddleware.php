<?php 
namespace TheWisePad\Application\Factories;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TheWisePad\Application\Factories\HelperFactorie;
use TheWisePad\Application\Authentication\Authentication;

class MakeAuthenticateMiddleware
{
    use HelperFactorie;

    protected $middleware;

    protected $app;

    public function __construct($app)
    {
        $this->middleware = new Authentication($this->getInstance(TOKEN_MANAGER));
        $this->app = $app;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        $response = $handler->handle($request);
        $token = $request->getHeader("Authorization");

        $responseOperation = $this->middleware->handle($token[0]);
    
        if($responseOperation['statusCode'] != 200) {
            $response = $this->app->getResponseFactory()->createResponse();
            
            return $this->adapteRoute($response, $responseOperation);
        }
        return $response;
    }
}