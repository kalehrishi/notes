<?php
namespace Notes\Controller\Web;

use Notes\Request\Request as Request;
   
$application->get('/:route', function ($route) use ($application) {
    $request = new Request();
    $request->setUrlParams($route);
    $homeController = new Home($request);
    $homeController->get();
})->conditions(array("route" => "(|home)"));

$application->get('/login', function () use ($application) {
    $request           = new Request();
    $sessionController = new Session($request);
    $sessionController->get();
});

$application->post('/login', function () use ($application) {
    $request = $application->request();
    
    $objRequest = new Request();
    $objRequest->setUrlParams($request->post());

    $sessionController = new Session($objRequest);
    $sessionController->post();
      
});

$application->get('/notes', function () use ($application) {
    $request = $application->request();
    
    $objRequest = new Request();
    
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);
    
    $notesController = new Notes($objRequest);
    $notesController->get();
});

$application->get('/note/read/:id', function ($id) use ($application) {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest        = new Request();
    $objRequest->setUrlParams($id);
    $objRequest->setCookies($request->cookies);

    $noteController = new Note($objRequest);
    $noteController->get();
});

$application->delete('/note/delete/:id', function ($id) use ($application) {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest        = new Request();
    $objRequest->setUrlParams($id);
    $objRequest->setCookies($request->cookies);
    $noteController = new Note($objRequest);
    $noteController->delete();
});


$application->get('/error', function () use ($application) {
    $request         = new Request();
    $errorController = new Error($request);
    $errorController->get();
});

$application->get('/logout', function () use ($application) {
    $request = $application->request();
    
    $objRequest = new Request();
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);
    
    $logoutController = new Logout($objRequest);
    $logoutController->get();
});

$application->post('/notes', function () use ($application) {
    $request = $application->request();
    
    $objRequest = new Request();
    $objRequest->setUrlParams($request->post());
    $objRequest->setCookies($request->cookies);
    
    $notesController = new Notes($objRequest);
    $notesController->post();
});

$application->get('/notes/create', function () use ($application) {
    $request = \Slim\Slim::getInstance()->request();
    $request        = new Request();

    $createController = new Create($request);
    $createController->get();
});

$application->post('/notes/create', function () use ($application) {
    $request = $application->request();

    $objRequest        = new Request();
    $objRequest->setData($request->getBody());
    $objRequest->setUrlParams($request->post());
    $objRequest->setCookies($request->cookies);
    
    $noteController = new Note($objRequest);
    $noteController->post();
});

$application->get('/notes/userTag', function () use ($application) {
    $request = \Slim\Slim::getInstance()->request();
    
    $objRequest        = new Request();
    
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);

    $userTagController = new UserTag($objRequest);
    $userTagController->get();
});

$application->get('/register', function () use ($application) {
    $request        = new Request();
    $userController = new User($request);
    $userController->get();
});

$application->post('/register', function () use ($application) {
    $request =$application->request();
   
    $objRequest = new Request();
    $objRequest->setUrlParams($request->post());

    $userController = new User($objRequest);
    $userController->post();

});
