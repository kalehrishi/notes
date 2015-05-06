<?php

require_once '../vendor/autoload.php';

$application = new \Slim\Slim(array(
    'debug' => true ));

require_once "../app/Router/Routes.php";

$application->run();
