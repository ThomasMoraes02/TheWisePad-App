<?php 
namespace TheWisePad\Application\Authentication;

use TheWisePad\Application\UseCases\Authentication\TokenManager;
use TheWisePad\Application\Web\HttpHelper;
use Throwable;

class Authentication implements Middleware
{
    use HttpHelper;

    private $tokenManager;

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function handle($request)
    {
        try {
            if(empty($request)) {
                return $this->forbidden('Invalid Token');
            }

            $decodedToken = $this->tokenManager->verify($request);

            if($decodedToken == false) {
                return $this->forbidden('Invalid Token');
            }

            return $this->ok(true);
        } catch(Throwable $e) {
            return $this->serverError('Invalid Token');
        }
    }
}