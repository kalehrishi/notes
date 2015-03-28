<?php

namespace Notes\Controller\Web;

require_once '../vendor/autoload.php';

use Notes\Request\Request as Request;

$application = new \Slim\Slim(array(
    'debug' => true
));

$application->get('/', function() {
    echo "test";
});

$application->map('/home', function() {
    $request        = new Request();
    $homeController = new Home($request);
    $homeController->show();
})->via('GET', 'POST');

$application->map('/login', function() {
    $request        = new Request();
    $userController = new User($request);
    $userController->login();
})->via('GET', 'POST');



$application->run();
