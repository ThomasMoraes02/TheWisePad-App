<?php 
namespace TheWisePad\Application;

use Throwable;
use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\ControllerOperation;

class SignInOperation implements ControllerOperation
{
    use HttpHelper;

    private $useCase;

    public $requiredParams = ['email', 'password'];

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
                return $this->created($response);
            }
        } catch(Throwable $e) {
            return $this->forbidden($e->getMessage());
        }

        return $this->badRequest($request);
    }
}