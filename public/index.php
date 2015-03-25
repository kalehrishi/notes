<?php

require_once '../vendor/autoload.php';

use Notes\Request\Request as Request;

use Notes\Controller\User as UserController;

$application = new \Slim\Slim(array('debug' => true));

$application->get('/home', function() {
    $application->get('/home', function() {
    echo "Wel-come to Sticky-notes";
    echo "<br><!DOCTYPE html><html><heda></head><body>";
    echo "<a href='http://www.google.com'>Login</a></body></html>"; 
});
$application->run();