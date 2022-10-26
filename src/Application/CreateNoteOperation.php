<?php 
namespace TheWisePad\Application;

use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\ControllerOperation;
use Throwable;

class CreateNoteOperation implements ControllerOperation
{
    use HttpHelper;

    public $requiredParams = ['title','content','email'];

    private $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function specificOp($request)
    {
        try {
            $response = $this->useCase->perform([
                'title' => $request['title'],
                'content' => $request['content'],
                'email' => $request['email']
            ]);

            return $this->created($response);
        } catch(Throwable $e) {
            return $this->forbidden($e->getMessage());
        }

        return $this->badRequest($request);
    }
}