<?php
require_once(LIB_FOLDER . 'ApiException.php');
class ApiException extends Exception {
    // Properties 
    private $isInternalErr;
    
    public function __construct($isInternalErr = false, $message = null, $code = 0, $previous = NULL) {
        parent::__construct($message, $code, $previous);
        $this->isInternalErr = $isInternalErr;        
        
    }
   
    public static function createFromException($ex, $message, $code = 0) {
        $apiException = null;
        if($ex instanceof ApiException) {
            $apiException = $ex;
        } else if($ex instanceOf Exception) {
            $apiException = new ApiException(true, $message, $code, $ex);
            //$apiException = array($ex,$message);
        } 
        return $apiException;        
    }
    
  
    public function isInternalError() {
        return $this->isInternalErr;
    }
}
