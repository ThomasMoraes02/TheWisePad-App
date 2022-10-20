<?php 
namespace TheWisePad\Application;

use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\ControllerOperation;
use TheWisePad\Application\Web\HttpHelper;
use Throwable;

class SignUpOperation implements ControllerOperation
{
    use HttpHelper;

    public $requiredParams = ['name', 'email', 'password'];

    private $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function specificOp($request)
    {
        try {
            $response = $this->useCase->perform([
                'name' => $request['name'],
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