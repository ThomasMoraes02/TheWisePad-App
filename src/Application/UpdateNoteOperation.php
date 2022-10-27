<?php 
namespace TheWisePad\Application;

use Throwable;
use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Application\UseCases\UseCase;
use TheWisePad\Application\Web\WebController;
use TheWisePad\Application\Web\ControllerOperation;

class UpdateNoteOperation implements ControllerOperation
{
    use HttpHelper;

    private $useCase;
    public $requiredParams = ['id', 'email'];

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function specificOp($request)
    {
        try {
            $missingParams = WebController::getMissingParams($request, $this->requiredParams);

            if(!empty($missingParams)) {
                $fields = '';
                foreach($missingParams as $params) {
                    $fields .= "$params ";
                }
                return $this->badRequest("Invalid fields: $fields");
            }

            $response = $this->useCase->perform($request);
            return $this->ok($response);

        } catch(Throwable $e) {
            return $this->badRequest($e->getMessage());
        }
    }
}