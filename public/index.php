<?php

require '../vendor/autoload.php';

//use Notes\Domain\UserTag as UserTagDomain;
//use Notes\Model\UserTag as UserTagModel;

use Notes\Request\Request as Request;
use Notes\Controller\User as UserController;


$app = new \Slim\Slim();

$app->get('/user/:user', function($user)
{
    
    
    $request     = new Request($user);
    $requestdata = $request->get();
    
    $userController = new UserController();
    $response       = $userController->create($requestdata);
    
    print_r($response);
});

$app->run();
