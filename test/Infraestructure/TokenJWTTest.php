<?php
namespace TheWisePad\Test\Infraestructure;

use PHPUnit\Framework\TestCase;
use TheWisePad\Infraestructure\TokenJWT;

class TokenJWTTest extends TestCase
{
    public function test_json_web_token()
    {
        $payload = [
            'name' => 'Thomas',
            'email' => 'thomas@gmail.com'
        ];

        $token = new TokenJWT();
        $tokenJwt = $token->sigIn($payload);

        $tokenVerify = $token->verify($tokenJwt);

        $this->assertTrue($tokenVerify);
    }
}