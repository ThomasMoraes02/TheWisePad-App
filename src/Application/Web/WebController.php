<?php 
namespace TheWisePad\Application\Web;

use Error;
use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Application\Web\ControllerOperation;
use Throwable;

class WebController 
{
    use HttpHelper;

    private $controllerOp;

    public function __construct(ControllerOperation $controllerOp)
    {
        $this->controllerOp = $controllerOp;
    }

    public function handle($request)
    {
        try {
            $missingParams = WebController::getMissingParams($request, $this->controllerOp->requiredParams);

            if(!empty($missingParams)) {
                return $this->badRequest($missingParams);
            }

            return $this->controllerOp->specificOp($request);

        } catch(Throwable $e) {
            return $this->serverError($e->getMessage());
        }
    }

    public static function getMissingParams($request, $requiredParams)
    {
        $missingParams = [];
    
        for ($i=0; $i < count($requiredParams); $i++) { 
            if(!in_array($requiredParams[$i], array_keys($request)) || empty($request[$requiredParams[$i]])) {
                $missingParams[] = $requiredParams[$i];
            }

        }
    
        return $missingParams;
    }
}