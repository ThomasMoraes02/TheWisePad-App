<?php 
namespace TheWisePad\Application\Authentication;

use Error;
use TheWisePad\Application\UseCases\Authentication\TokenManager;
use TheWisePad\Application\Web\HttpHelper;

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
            if(empty($request['accessToken']) || empty($request['id'])) {
                return $this->forbidden(new Error('Invalid token or user id'));
            }

            $decodedToken = $this->tokenManager->verify($request['accessToken']);

            if($decodedToken == false) {
                return $this->forbidden(false);
            }

            return $this->ok(true);
        } catch(Error $e) {
            return $this->serverError($e);
        }
    }
}