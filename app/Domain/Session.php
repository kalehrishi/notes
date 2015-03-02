<?php
namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;
use Notes\Mapper\Session as SessionMapper;
use Notes\Model\Session as SessionModel;
use Notes\Domain\User as UserDomain;
use Notes\Validator\InputValidator as InputValidator;

class Session
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    public function create($userModel, $sessionModel)
    {
        try {
            $userDomain    = new UserDomain();
            $userModelRead = $userDomain->readByUsernameandPassword($userModel);
            if (!empty($userModelRead)) {
                $sessionModel->setUserId($userModelRead->getId());
                if ($this->validator->notNull($sessionModel->getUserId())
                && $this->validator->validNumber($sessionModel->getUserId())) {
                    $sessionMapper = new SessionMapper();
                    $sessionModel  = $sessionMapper->create($sessionModel);
                    return $sessionModel;
                }
            }
        } catch (Notes\Exception\ModelNotFoundException $e) {
            echo "Can Not Found Given Model In Database:" . $e->getMessage();
        }
    }
    
    public function read($sessionModel)
    {
        if ($this->validator->notNull($sessionModel->getId())
        && $this->validator->validNumber($sessionModel->getId())) {
            $sessionMapper = new SessionMapper();
            $sessionModel  = $sessionMapper->read($sessionModel);
            return $sessionModel;
        }
    }
    
    public function getSessionByAuthTokenAndUserId($sessionModel)
    {
        if ($this->validator->notNull($sessionModel->getUserId())
        && $this->validator->validNumber($sessionModel->getUserId())
        && $this->validator->notNull($sessionModel->getAuthToken())) {
            $sessionMapper = new SessionMapper();
            $sessionModel  = $sessionMapper->read($sessionModel);
            return $sessionModel;
        }
    }
    
    public function delete($sessionModel)
    {
        if ($this->validator->notNull($sessionModel->getId())
        && $this->validator->validNumber($sessionModel->getId())
        && $this->validator->notNull($sessionModel->getUserId())
        && $this->validator->validNumber($sessionModel->getUserId())) {
            $sessionMapper = new SessionMapper();
            $sessionModel  = $sessionMapper->update($sessionModel);
            return $sessionModel;
        }
    }
}
