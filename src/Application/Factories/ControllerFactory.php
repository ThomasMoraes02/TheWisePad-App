<?php 
namespace TheWisePad\Application\Factories;

use TheWisePad\Application\SignUpOperation;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;
use TheWisePad\Application\UseCases\SignUp;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Infraestructure\Note\NoteRepositoryMemory;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\TokenJWT;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class ControllerFactory
{
    public static function makeUserRepository()
    {
        return new UserRepositoryMemory();
    }

    public static function makeNoteRepository()
    {
        return new NoteRepositoryMemory();
    }

    public static function makeEncoder()
    {
        return new PasswordArgonII();
    }

    public static function makeTokenManager()
    {
        return new TokenJWT();
    }

    public static function makeSignUpController(): WebController
    {
        $userRepository = self::makeUserRepository();
        $encoder = self::makeEncoder();
        $tokenManager = self::makeTokenManager();

        $authenticationService = new CustomAuthentication($userRepository, $encoder, $tokenManager);
        $useCase = new SignUp($userRepository, $encoder, $authenticationService);

        $controller = new WebController(new SignUpOperation($useCase));

        return $controller;
    }
}