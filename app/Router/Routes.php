<?php
namespace Notes\Controller\Web;

use Notes\Request\Request as Request;

$this->application->get('/:route', function ($route) {
    $request = new Request();
    $request->setUrlParams($route);
    $homeController = new Home($request);
    $homeController->get();
})->conditions(array("route" => "(|home)"));

$this->application->get('/login', function () {
    $request           = new Request();
    $sessionController = new Session($request);
    $sessionController->get();
});

$this->application->post('/login', function () {
    $request = $this->application->request();
    
    $objRequest = new Request();
    $objRequest->setUrlParams($request->post());

    $sessionController = new Session($objRequest);
    $sessionController->post();
});

$this->application->get('/notes', function () {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest = new Request();
    
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);
    
    $notesController = new Notes($objRequest);
    $notesController->get();
});

$this->application->get('/error', function () {
    $request         = new Request();
    $errorController = new Error($request);
    $errorController->get();
});

$this->application->get('/logout', function () {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest = new Request();
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);
    
    $logoutController = new Logout($objRequest);
    $logoutController->get();
});

$this->application->post('/notes', function () {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest = new Request();
    $objRequest->setUrlParams($request->post());
    $objRequest->setCookies($request->cookies);
    
    $notesController = new Notes($objRequest);
    $notesController->post();
});

$this->application->get('/register', function () {
    $request        = new Request();
    $userController = new User($request);
    $userController->get();
});

$this->application->post('/register', function () {
    $request = $this->application->request();
    
    $objRequest = new Request();
    $objRequest->setUrlParams($request->post());

    $userController = new User($objRequest);
    $userController->post();
});
