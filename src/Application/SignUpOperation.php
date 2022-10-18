<?php 
namespace TheWisePad\Application;

use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\ControllerOperation;
use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Domain\Exceptions\UserNotFound;

class SignUpOperation implements ControllerOperation
{
    use HttpHelper;

    private $requiredParams = ['email', 'password'];

    private $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function specificOp($request)
    {
        try {
            $response = $this->useCase->perform([
                'email' => $request['email'],
                'password' => $request['password']
            ]);
    
            if($response['email'] == $request['email']) {
                $this->created($response);
            }
        } catch(UserNotFound $e) {
            return $this->forbidden($e);
        }

        return $this->badRequest($request);
    }
}