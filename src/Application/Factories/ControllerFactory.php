<?php 
namespace TheWisePad\Application\Factories;

use TheWisePad\Application\Authentication\Authentication;
use TheWisePad\Application\CreateNoteOperation;
use TheWisePad\Application\LoadNoteOperation;
use TheWisePad\Application\RemoveNoteOperation;
use TheWisePad\Application\SignUpOperation;
use TheWisePad\Application\UpdateNoteOperation;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;
use TheWisePad\Application\UseCases\CreateNote;
use TheWisePad\Application\UseCases\LoadNote;
use TheWisePad\Application\UseCases\RemoveNote;
use TheWisePad\Application\UseCases\SignIn;
use TheWisePad\Application\UseCases\SignUp;
use TheWisePad\Application\UseCases\UpdateNote;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Infraestructure\Note\NoteRepositoryPdo;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\TokenJWT;
use TheWisePad\Infraestructure\User\UserRepositoryPdo;

class ControllerFactory
{
    public static function makeUserRepository()
    {
        return new UserRepositoryPdo();
    }

    public static function makeNoteRepository()
    {
        return new NoteRepositoryPdo();
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

    public static function makeLoadNoteController()
    {
        $noteRepository = self::makeNoteRepository();

        $useCase = new LoadNote($noteRepository);
        $controller = new WebController(new LoadNoteOperation($useCase));

        return $controller;
    }

    public static function makeUpdateNoteController()
    {
        $userRepository = self::makeUserRepository();
        $noteRepository = self::makeNoteRepository();

        $useCase = new UpdateNote($noteRepository, $userRepository);
        $controller = new WebController(new UpdateNoteOperation($useCase));

        return $controller;
    }

    public static function makeRemoveNoteController()
    {
        $noteRepository = self::makeNoteRepository();

        $useCase = new RemoveNote($noteRepository);
        $controller = new WebController(new RemoveNoteOperation($useCase));

        return $controller;
    }

    public static function makeAuthMiddleware()
    {
        $middleware = new Authentication(self::makeTokenManager());
        return $middleware;
    }
}