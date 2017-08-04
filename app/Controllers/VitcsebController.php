<?php

require_once(__DIR__ . '/../../config.php');
require_once (LIB_FOLDER . 'ApiHandler.php');
require_once (__DIR__ . '/../Models/Vitcseb.php');

class VitcsebController {
    
    public function __construct() {
        Apihandler::addActions('getAllVitPosts', array($this, 'getAllVitPosts'));
        Apihandler::addActions('addCommentToComTab', array($this, 'addCommentToComTab'));
        Apihandler::addActions('showCommsRel', array($this, 'showCommsRel'));
        Apihandler::addActions('addLikeForComment', array($this, 'addLikeForComment'));
        Apihandler::addActions('addDislikeForComment', array($this, 'addDislikeForComment'));
        Apihandler::addActions('storeUserPost', array($this, 'storeUserPost'));
        
        $this->apiHandler = ApiHandler::getInstance();
    }
    
     public function storeUserPost($data) {
        try {
            $vitcse = new Vitcseb();
            $result = $vitcse->storeUserPost($data);
            $this->apiHandler->showResponse($result, 'All posts fetched successfully.');
        } catch (ApiException $ex) {
            $this->apiHandler->showResponse($ex);
        }
    }
    
    public function getAllVitPosts($data) {
        try {
            $vitcse = new Vitcseb();
            $result = $vitcse->getAllVitPosts($data);
            $this->apiHandler->showResponse($result, 'All posts fetched successfully.');
        } catch (ApiException $ex) {
            $this->apiHandler->showResponse($ex);
        }
    }
    
    public function addCommentToComTab($data) {
        try {
            $vitcse = new Vitcseb();
            $result = $vitcse->addCommentToComTab($data);
            $this->apiHandler->showResponse($result, 'You have successfully submitted your comment.');
        } catch (ApiException $ex) {
            $this->apiHandler->showResponse($ex);
        }
    }
    
    public function showCommsRel($data) {
        try {
            $vitcse = new Vitcseb();
            $result = $vitcse->showCommsRel($data);
            $this->apiHandler->showResponse($result, 'Comments fetched successfully.');
        } catch (ApiException $ex) {
            $this->apiHandler->showResponse($ex);
        }
    }
    
    public function addLikeForComment($data) {
        try {
            $vitcse = new Vitcseb();
            $result = $vitcse->addLikeForComment($data);
            $this->apiHandler->showResponse($result, 'All posts fetched successfully.');
        } catch (ApiException $ex) {
            $this->apiHandler->showResponse($ex);
        }
    }
    
    public function addDislikeForComment($data) {
        try {
            $vitcse = new Vitcseb();
            $result = $vitcse->addDislikeForComment($data);
            $this->apiHandler->showResponse($result, 'All posts fetched successfully.');
        } catch (ApiException $ex) {
            $this->apiHandler->showResponse($ex);
        }
    }
    
}
