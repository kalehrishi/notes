<?php

namespace Notes\Controller\Web;

require_once '../vendor/autoload.php';

use Notes\Request\Request as Request;

$application = new \Slim\Slim(array(
    'debug' => true
));

$application->get('/:route', function($route) {
    $request        = new Request();
    $request->setUrlParams($route);
    $homeController = new Home($request);
    $homeController->get();
})->conditions(array("route" => "(|home)"));


$application->get('/login', function() {
    $request        = new Request();
    $sessionController = new Session($request);
    $sessionController->get();
});
$application->post('/login', function() {
    $request = \Slim\Slim::getInstance()->request();

    $objRequest        = new Request();
    $objRequest->setUrlParams($request->post());
    
    $sessionController = new Session($objRequest);
    $sessionController->post();
});
$application->get('/notes', function() {
   echo"Login Successfully";
});

$application->get('/Register', function() {
    $request        = new Request();
    $userController = new User($request);
    $userController->get();
});
$application->post('/Register', function() {
    $request = \Slim\Slim::getInstance()->request();

    $objRequest        = new Request();
    $objRequest->setUrlParams($request->post());
    
    $userController = new User($objRequest);
    $userController->post();
});

$application->run();
