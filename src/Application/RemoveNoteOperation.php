<?php 
namespace TheWisePad\Application;

use Throwable;
use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\ControllerOperation;

class RemoveNoteOperation implements ControllerOperation
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
            $this->useCase->perform($request);
            return $this->ok('Note successfully removed.');
        } catch(Throwable $e) {
            return $this->badRequest($e->getMessage());
        }
        return $this->badRequest($request);
    }
}