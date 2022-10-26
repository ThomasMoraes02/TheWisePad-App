<?php 
namespace TheWisePad\Application;

use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\ControllerOperation;
use TheWisePad\Application\Web\HttpHelper;
use Throwable;

class LoadNoteOperation implements ControllerOperation
{
    use HttpHelper;

    private $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function specificOp($request)
    {
        try {
            $response = $this->useCase->perform($request);
            return $this->ok($response);
        } catch(Throwable $e) {
            return $this->badRequest($e->getMessage());
        }
        return $this->badRequest($request);
    }
}