<?php 
namespace TheWisePad\Application\Web;

use Error;
use TheWisePad\Application\Web\HttpHelper;
use TheWisePad\Application\Web\ControllerOperation;

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
            $missingParams = WebController::getMissingParams($request, $this->controllerOp['requiredParams']);

            if(!empty($missingParams)) {
                return $this->badRequest($missingParams);
            }

            $this->controllerOp->specificOp($request);

        } catch(Error $e) {
            return $this->serverError($e);
        }
    }

    public static function getMissingParams($httpRequest, array $requiredParams)
    {
        $missingParams = [];
        $missingParams = array_udiff($requiredParams, $httpRequest, function($a, $b) {
            if($a != $b) {
                return $a;
            }
        });
        
        return $missingParams;
    }
}