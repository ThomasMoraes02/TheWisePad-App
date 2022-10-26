<?php 
namespace TheWisePad\Infraestructure;

use DateTime;
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

        // 5 dias
        $expirationTime = time() + 60 * 60 * 24 * JWT_EXPIRATION_TOKEN;

        $payload = [
            'iss' => JWT_SECRET_TOKEN,
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
        if(strpos($token, 'Bearer') == true) {
            $token = explode('Bearer ',$token)[1];
        }
        $part = explode(".",$token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload","token",true);
        $valid = base64_encode($valid);

        $payloadDecoded = $this->base64_decode_url($payload);
        
        $expiresToken = new DateTime(date('Y-m-d',$payloadDecoded->exp));
        $now = new DateTime();

        $interval = $expiresToken->diff($now);

        if($signature != $valid && $payloadDecoded->iss != ENCODER && $interval->days > 5) {
            return false;
        }
        return true;
    }

    private function base64_decode_url($string)
    {
        return json_decode(base64_decode(str_replace(['-','_'], ['+','/'], $string)));
    }
}