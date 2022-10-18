<?php 
namespace TheWisePad\Infraestructure;

use TheWisePad\Application\UseCases\Authentication\TokenManager;

class TokenJWT implements TokenManager
{
    public function sigIn($payload, $expires = null): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = json_encode($header);
        $header = base64_encode($header);

        // 60 dias
        $expirationTime = time() + 60 * 60 * 24 * 60;

        $payload = [
            'iss' => 'token',
            'exp' => $expirationTime,
            'name' => $payload['name'],
            'email' => $payload['email']
        ];

        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256',"$header.$payload",'token',true);
        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    public function verify(string $token): bool
    {
        $part = explode(".",$token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload","token",true);
        $valid = base64_encode($valid);

        if($signature != $valid) {
            return false;
        }
        return true;
    }
}