<?php 
namespace TheWisePad\Application\UseCases;

use TheWisePad\Domain\Email;
use TheWisePad\Application\UseCases\Authentication\AuthenticationService;

class SignIn implements UseCase
{
    private $authentication;

    public function __construct(AuthenticationService $authentication)
    {
        $this->authentication = $authentication;
    }

    public function perform(array $request): array
    {
        $response = $this->authentication->auth([
            'email' => new Email($request['email']),
            'password' => $request['password']
        ]);

        return $response;
    }
}