<?php

require_once '../vendor/autoload.php';

use Notes\Request\Request as Request;

use Notes\Controller\User as UserController;

use Notes\View\View as View;

$application = new \Slim\Slim(array('debug' => true));

$application->get('/home', function() {
	$fileName="home.html";
    $view = new View();
    $view->render($fileName);
});
$application->run();