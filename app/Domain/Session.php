<?php
namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\Session as SessionMapper;

use Notes\Model\Session as SessionModel;

use Notes\Domain\User as UserDomain;

use Notes\Validator\InputValidator as InputValidator;

use Notes\Factory\User as UserFactory;

class Session
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    public function create($userModel)
    {
        $sessionModel  = new sessionModel();
        $userDomain    = new UserDomain();
        $userModelRead = $userDomain->readByUserNameAndPassword($userModel);
        
        $sessionModel->setUserId($userModelRead->getId());

        $randomNumber = rand();

        $password = $userModelRead->getPassword();
        
        $sessionModel->createAuthToken($password, $randomNumber);
        
        $sessionModel->setCreatedOn(date("Y-m-d H:i:s"));
        
        $this->validator->notNull($sessionModel->getUserId());
        $this->validator->validNumber($sessionModel->getUserId());
        $this->validator->notNull($sessionModel->getAuthToken());
        
            $sessionMapper = new SessionMapper();
            $sessionModel  = $sessionMapper->create($sessionModel);
            return $sessionModel;
    }
    public function read($sessionModel)
    {
        $this->validator->notNull($sessionModel->getId());
        $this->validator->validNumber($sessionModel->getId());
            $sessionMapper = new SessionMapper();
            
            $sessionModel = $sessionMapper->read($sessionModel);

            return $sessionModel;
    }
    
    public function getSessionByAuthTokenAndUserId($sessionModel)
    {
        $this->validator->notNull($sessionModel->getUserId());
        $this->validator->validNumber($sessionModel->getUserId());
        $this->validator->notNull($sessionModel->getAuthToken());
            $sessionMapper = new SessionMapper();
            
            $sessionModel = $sessionMapper->read($sessionModel);

            return $sessionModel;
    }
    
    public function delete($sessionModel)
    {
        $this->validator->notNull($sessionModel->getId());
        $this->validator->validNumber($sessionModel->getId());
        $this->validator->notNull($sessionModel->getUserId());
        $this->validator->validNumber($sessionModel->getUserId());
            $sessionModel->setIsExpired(1);
            $sessionModel->setExpiredOn(date("Y-m-d H:i:s"));
            $sessionMapper = new SessionMapper();
            
            $sessionModel = $sessionMapper->update($sessionModel);
            
            return $sessionModel;
    }
}
