<?php

require '../vendor/autoload.php';

use Notes\Request\Request as Request;
use Notes\Response\Response as Response;
use Notes\Controller\User as UserController;

$application = new \Slim\Slim(array(
    'debug' => true
));


$application->get('/env', function() {
    $env = \Slim\Environment::getInstance();
    echo "<br/>slim.url_scheme=" . $env['slim.url_scheme'];
    echo "<br/>REQUEST_METHOD=" . $env['REQUEST_METHOD'];
    echo "<br/>SCRIPT_NAME=" . $env['SCRIPT_NAME'];
    echo "<br/>PATH_INFO=" . $env['PATH_INFO'];
    echo "<br/>SERVER_NAME=" . $env['SERVER_NAME'];
    
});

$application->get('/', function() {
    echo "Home Page";
});

$application->post('/register', function() {
    $paramsData = \Slim\Slim::getInstance()->request()->getBody();
    
    $objRequest = new Request($paramsData);
    $request    = $objRequest->read();
    
    $userController = new UserController();
    $response       = $userController->create($request);
    
    $objResopnse = new Response();
    $data        = $objResopnse->toJson($response);
    echo $data;
});
$application->run();
