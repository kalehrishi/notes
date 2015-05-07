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
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest        = new Request();
    
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);

    $notesController = new Notes($objRequest);
    $notesController->get();
});

$application->get('/notes/:id', function($id) {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest        = new Request();
    $objRequest->setUrlParams($id);
    $objRequest->setCookies($request->cookies);

    $noteController = new Note($objRequest);
    $noteController->get();
});

$application->delete('/notes/:id', function ($id) {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest        = new Request();
    $objRequest->setUrlParams($id);
    $objRequest->setCookies($request->cookies);
    $noteController = new Note($objRequest);
    $noteController->delete();
});

$application->get('/error', function() {
    $request        = new Request();
    $errorController = new Error($request);
    $errorController->get();
});

$application->get('/logout', function() {
    $request = \Slim\Slim::getInstance()->request();

    $objRequest        = new Request();
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);

    $logoutController = new Logout($objRequest);
    $logoutController->get();
});

$application->get('/notes/create', function() {
    $request        = new Request();
    
    $createController = new Create($request);
    $createController->get();
});

$application->post('/notes/create', function() {
    $request = \Slim\Slim::getInstance()->request();

    $objRequest        = new Request();
    $objRequest->setUrlParams($request->post());
    $objRequest->setCookies($request->cookies);
    
    $createController = new Create($objRequest);
    $createController->post();
});

$application->post('/notes', function() {
    $request = \Slim\Slim::getInstance()->request();

    $objRequest        = new Request();
    $objRequest->setUrlParams($request->post());
    $objRequest->setCookies($request->cookies);
    
    $notesController = new Notes($objRequest);
    $notesController->post();
});

$application->get('/register', function() {
    $request        = new Request();
    $userController = new User($request);
    $userController->get();
});
$application->post('/register', function() {
    $request = \Slim\Slim::getInstance()->request();

    $objRequest        = new Request();
    $objRequest->setUrlParams($request->post());
    
    $userController = new User($objRequest);
    $userController->post();
});


$application->run();