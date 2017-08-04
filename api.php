<?php

require_once (__DIR__ . '/lib/ApiHandler.php');

ApiHandler::loadController('Vitcseb');


$vitcseb = new VitcsebController();
$apiHandler=ApiHandler::getInstance();

if(isset($_REQUEST['details'])){
    $method = $_REQUEST['details']['method'];
    $data = $_REQUEST['details'];
    $apiHandler->trigger($method,$data);
}



 