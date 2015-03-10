<?php
namespace Notes\Factory;

use Notes\Model\Session as SessionModel;
use Notes\Validator\InputValidator as InputValidator;

class Session
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    public function create($userModel)
    {
        $sessionModel = new SessionModel();
       
        $sessionModel->setUserId($userModel->getId());
        
        $randomNumber = rand(10, 100);

        $password = $userModel->getPassword();

        $sessionModel->createAuthToken($password, $randomNumber);
        
        $sessionModel->setCreatedOn(date("Y-m-d H:i:s"));

        if ($this->validator->notNull($sessionModel->getUserId())
        && $this->validator->validNumber($sessionModel->getUserId())
        && $this->validator->notNull($sessionModel->getAuthToken())) {
            return $sessionModel;
        }
    }
}
