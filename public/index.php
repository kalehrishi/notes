<?php

require_once '../vendor/autoload.php';

$application = new \Slim\Slim(array(
    'debug' => true
));

$application->setName('developer');

require_once "../app/Routes/Routes.php";

$application->run();
