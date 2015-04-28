<?php

namespace Notes\Controller\Web;

require_once '../vendor/autoload.php';

use Notes\Request\Request as Request;


$application = new \Slim\Slim(array(
    'debug' => true ));

require_once "../app/app.php";

$application->run();
