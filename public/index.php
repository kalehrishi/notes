<?php

namespace Notes\Domain;

require '../vendor/autoload.php';

use Notes\Model\UserTag as UserTagModel;

$app = new \Slim\Slim();

$app->get('/tag/:tag', function ($tag) {

    $userTagModel= new UserTagModel();
    
    $userTagModel->setUserId(2);
    $userTagModel->setTag($tag);

    $userTagDomain= new UserTag();
    
    $result=$userTagDomain->create($userTagModel);

    print_r($result);
});

$app->run();

