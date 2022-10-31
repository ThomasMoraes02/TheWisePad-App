<?php
namespace TheWisePad\Test\Infraestructure;

use PHPUnit\Framework\TestCase;
use TheWisePad\Infraestructure\TokenJWT;

class TokenJWTTest extends TestCase
{
    public function test_json_web_token()
    {
        $payload = [
            'iss' => JWT_SECRET_TOKEN,
            'exp' => JWT_EXPIRATION_TOKEN,
            'name' => 'Thomas',
            'email' => 'thomas@gmail.com'
        ];

        $token = new TokenJWT();
        $tokenJwt = $token->sigIn($payload);

        $tokenVerify = $token->verify($tokenJwt);

        $this->assertTrue($tokenVerify);
    }

    public function test_access_token_expires()
    {
        $token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJ0b2tlbi1qd3QtdGhld2lzZWRldiIsImV4cCI6MTY2NjkwOTg5MywibmFtZSI6IkNhaXF1ZSBNb3JhZXMiLCJlbWFpbCI6ImNhaXF1ZUBnbWFpbC5jb20ifQ==.AlrSkYHS+GDdWy7tvNZbIza1JVOx4jBbaEhoanzRntQ=";

        $tokenJwt = new TokenJWT;

        $tokenVerify = $tokenJwt->verify($token);

        $this->assertFalse($tokenVerify);
    }
}