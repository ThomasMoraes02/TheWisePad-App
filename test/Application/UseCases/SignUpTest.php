<?php
namespace TheWisePad\Test\Application\UseCases;

use PHPUnit\Framework\TestCase;
use TheWisePad\Application\UseCases\Authentication\CustomAuthentication;
use TheWisePad\Application\UseCases\SignUp;
use TheWisePad\Domain\User\User;
use TheWisePad\Infraestructure\PasswordArgonII;
use TheWisePad\Infraestructure\TokenUniqId;
use TheWisePad\Infraestructure\User\UserRepositoryMemory;

class SignUpTest extends TestCase
{
    private $userRepository;

    private $user;

    private $encoder;

    private $authentication;

    public function setUp()
    {
        $this->userRepository = new UserRepositoryMemory();
        $this->encoder = new PasswordArgonII();

        $this->user = User::create("Thomas", "thomas@gmail.com", new PasswordArgonII("123456"));
        $this->userRepository->addUser($this->user);

        $this->authentication = new CustomAuthentication($this->userRepository, $this->encoder, new TokenUniqId);
    }

    public function test_sign_up()
    {
        $signUp = new SignUp($this->userRepository, $this->encoder, $this->authentication);

        $request = [
            'name' => 'Thomas',
            'email' => 'thomas@gmail.com',
            'password' => '123456'
        ];

        $response = $signUp->perform($request);

        $this->assertEquals("thomas@gmail.com", $response['email']);
    }
}