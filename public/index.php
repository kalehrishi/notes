<?php

require '../vendor/autoload.php';

use Notes\Request\Request as Request;

use Notes\Controller\User as UserController;


$application = new \Slim\Slim(array('debug' => true));


$application->get('/login/:id', function($id) {
    echo "Home Page $id";
});

$application->post('/register', function() {
    setcookie('firstName', 'Joy', time() + (86400 * 30), "/");
    $request = \Slim\Slim::getInstance()->request();
   
    $objRequest=new Request(); 
    $objRequest->setData($request->getBody());
    $objRequest->setHeaders($request->headers);
    $objRequest->setCookies($request->cookies);
         
    /*print_r($objRequest->getData());
    echo "<br><br>";
    $headers=$objRequest->getHeaders();
    print_r($headers['Connection']);
    echo "<br><br>cookies----";
    print_r($objRequest->getCookies());
*/

    $userController=new UserController($objRequest);
    $response=$userController->create();
    echo "<br><br><br> Output <br><br><br>".$response;
});

$application->post('/update', function() {
    $request = \Slim\Slim::getInstance()->request()->getBody();
    

    $objRequest=new Request();
    $objRequest->setPostData($request);
   
    $userController=new UserController($objRequest);
    $response=$userController->update();

    $objResopnse=new Response();
    $data=$objResopnse->to_json($response);
    echo $data;
});

$application->post('/read',  function () {
         $request = \Slim\Slim::getInstance()->request();
        
        $objRequest=new Request();
        $objRequest->setUrlParams($request->get());

       // print_r($objRequest->getUrlParams());

        $userController=new UserController($objRequest);
        $response=$userController->read();
        echo $response;

       
        
});

$application->post('/demo',  function () {
         $request = \Slim\Slim::getInstance()->request();
        
        $objRequest=new Request();
        $objRequest->setData($request->getBody());

        print_r($objRequest->getData());

        /*$userController=new UserController($objRequest);
        $response=$userController->read();*/


       
        
});


$application->run();
