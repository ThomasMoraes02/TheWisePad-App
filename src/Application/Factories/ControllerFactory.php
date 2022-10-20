<?php 
namespace TheWisePad\Application\Factories;

use TheWisePad\Application\CreateNoteOperation;
use TheWisePad\Application\SignUpOperation;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;
use TheWisePad\Application\UseCases\CreateNote;
use TheWisePad\Application\UseCases\SignIn;
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

    public static function makeSignInController()
    {
        $userRepository = self::makeUserRepository();
        $encoder = self::makeEncoder();
        $tokenManager = self::makeTokenManager();

        $authenticationService = new CustomAuthentication($userRepository, $encoder, $tokenManager);
        $useCase = new SignIn($authenticationService);

        $controller = new WebController(new SignUpOperation($useCase));

        return $controller;
    }

    public static function makeCreateNoteController()
    {
        $userRepository = self::makeUserRepository();
        $noteRepository = self::makeNoteRepository();

        $useCase = new CreateNote($noteRepository, $userRepository);
        $controller = new WebController(new CreateNoteOperation($useCase));

        return $controller;
    }
}