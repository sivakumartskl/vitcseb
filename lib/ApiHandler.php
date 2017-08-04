<?php

require_once(__DIR__ . '/../config.php');
require_once(LIB_FOLDER . 'ApiException.php');

class ApiHandler {

    private static $actions = array();
    public static $event;

    /**
     * Private constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    private function __construct() {
        
    }

    public static function getInstance() {
        if (null === ApiHandler::$event) {
            ApiHandler::$event = new Apihandler();
        }
        return ApiHandler::$event;
    }

    // Function to add the methods to the $actions array
    public static function addActions($actionName, $callBackArray) {
        //Apihandler::$actions = array($actionName => $callBackArray, $authLevel);
        if (array_key_exists($actionName, ApiHandler::$actions)) {
            throw new Exception("Trying to add an action that already exists - $actionName !");
        }
        Apihandler::$actions[$actionName] = array('callback' => $callBackArray);
    }

    // Function to load the controller
    public static function loadController($controllerName) {
        require(BASE_CONTROLLER_FOLDER . $controllerName . 'Controller.php');
    }

    public static function loadModels($modelName) {
        require_once(BASE_MODEL_FOLDER . $modelName);
    }

    // Function to trigger the events 
    public function trigger($eventName, $data) {
        if (array_key_exists($eventName, ApiHandler::$actions)) {
            $functionToCall = ApiHandler::$actions[$eventName]['callback'];
            call_user_func($functionToCall, $data);
        } else {
            echo 'The function is not valid';
        }
    }

    // Function to show the response in json format.
    public function showResponse($data, $msg = '') {
        $responseData = array();
        $responseData['data'] = $data;
        if ($data instanceof ApiException) {
            if ($data->isInternalError()) {
                // 500
                header('HTTP/ 500 Internal Server Error');
                $responseData['code'] = 'error';
                $responseData['message'] = $data->getMessage();
            } else {
                // 400
                header('HTTP/ 400 Bad Request');
                $responseData['code'] = 'fail';
                $responseData['message'] = $data->getMessage();
            }
        } else {
            // Everything went well, echo 200 status code.
            header('Content-Type: application/json');
            header('HTTP/ 200 Success');
            $responseData['code'] = 'success';
            $responseData['message'] = $msg;
        }
        echo json_encode($responseData);
        die();
    }

}
