<?php 
namespace TheWisePad\Application\UseCases;

use DomainException;
use TheWisePad\Domain\User\UserRepository;
use TheWisePad\Application\UseCases\Authentication\AuthenticationService;
use TheWisePad\Domain\Email;
use TheWisePad\Domain\Exceptions\UserNotFound;
use TheWisePad\Domain\PasswordEncoded;
use TheWisePad\Domain\User\User;

class SignUp implements UseCase
{
    private $userRepository;

    private $encoder;

    private $authentication;

    public function __construct(UserRepository $userRepository, PasswordEncoded $encoder, AuthenticationService $authentication)
    {
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->authentication = $authentication;
    }

    public function perform(array $request): array
    {
        try {
            $user = $this->userRepository->findByEmail(new Email($request['email']));

            $userPassword = $this->encoder->verify($request['password'], strval($user->getPassword()));

            if($userPassword == false) {
                throw new DomainException("Invalid password");
            }

        } catch(UserNotFound $e) {
            $user = User::create($request['name'], $request['email'], new $this->encoder($request['password']));
            $this->userRepository->addUser($user); 
        }

        $response = $this->authentication->auth([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $request['password']
        ]);

        return $response;
    }
}