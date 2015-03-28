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
    // $app = new \Slim\Slim();
    // $req= $app->request->getBody();
    // print_r(parse_url($req));

    $email=$_POST['email'];
    $password=$_POST['password'];
    $request        = new Request();
    $request->setData(json_encode(array("email"=>$email,"password"=>$password)));
    $sessionController = new Session($request);
    $sessionController->post();
});



$application->run();
