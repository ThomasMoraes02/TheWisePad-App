<?php 
namespace TheWisePad\Application\UseCases\Authentication;

use DomainException;
use TheWisePad\Domain\PasswordEncoded;
use TheWisePad\Domain\User\UserRepository;

class CustomAuthentication implements AuthenticationService
{
    private $userRepository;

    private $encoder;

    private $tokenManager;

    public function __construct(UserRepository $userRepository, PasswordEncoded $encoder, TokenManager $tokenManager)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->tokenManager = $tokenManager;
    }

    public function auth(array $authenticationParams): array
    {
        $user = $this->userRepository->findByEmail($authenticationParams['email']);

        $passwordCompare = $this->encoder->verify($authenticationParams['password'], strval($user->getPassword()));

        if($passwordCompare == false) {
            throw new DomainException("Invalid password");
        }

        $accessToken = $this->tokenManager->sigIn(['email' => strval($user->getEmail()), 'name' => $user->getName()]);

        return [
            'accessToken' => $accessToken,
            'email' => strval($user->getEmail())
        ];
    }
}