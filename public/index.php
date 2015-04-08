<?php
require '../vendor/autoload.php';

$userService=new Notes\Service\User();
$input=array('firstName'=>'FirstName','lastName'=>'LastName','email'=>'test@notes.com');
print_r($userService->createUser($input));