<?php 
namespace TheWisePad\Application\Web;

Trait HttpHelper
{
    public function ok($data): array
    {
        return [
            'statusCode' => 200,
            'body' => $data
        ];
    }

    public function created($data): array
    {
        return [
            'statusCode' => 201,
            'body' => $data
        ];
    }

    public function forbidden($data): array
    {
        return [
            'statusCode' => 403,
            'body' => $data
        ];
    }

    public function badRequest($data): array
    {
        return [
            'statusCode' => 400,
            'body' => $data
        ];
    }

    public function serverError($data): array
    {
        return [
            'statusCode' => 500,
            'body' => $data
        ];
    }
}