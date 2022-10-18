<?php 
namespace TheWisePad\Application\Factories;

use TheWisePad\Application\SignUpOperation;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;
use TheWisePad\Application\UseCases\SignUp;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\TokenJWT;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class makeSignUpController
{
    public function __construct()
    {
        $userRepository = new UserRepositoryMemory();
        $encoder = new PasswordArgonII();
        $tokenManager = new TokenJWT();
        $authenticationService = new CustomAuthentication($userRepository, $encoder, $tokenManager);

        $useCase = new SignUp($userRepository, $encoder, $authenticationService);

        $controller = new WebController(new SignUpOperation($useCase));

        return $controller;
    }
}