<?php
namespace Notes\Domain;

use Notes\Mapper\Note as NoteMapper;
use Notes\Model\Note as NoteModel;
use Notes\Config\Config as Configuration;
use Notes\Validator\InputValidator as InputValidator;
use Notes\Domain\UserTag as UserTagDomain;
use Notes\Model\UserTag as UserTagModel;

class Note
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    public function create(NoteModel $noteModel, UserTagModel $userTagModel)
    {
        if ($this->validator->notNull($noteModel->getUserId())
        	&& $this->validator->validNumber($noteModel->getUserId())
        	&& $this->validator->notNull($noteModel->getTitle())
        	&& $this->validator->notNull($noteModel->getBody())) {
            $noteUserTagDomain      = new UserTagDomain();
            $resultsetUserTagDomain = $noteUserTagDomain->create($userTagModel);
            
            $noteMapper = new NoteMapper();
            $resultset  = $noteMapper->create($noteModel);
            
            
            
            
            $noteModel->setId($resultset->id);
            $noteModel->setUserId($resultset->userId);
            $noteModel->setTitle($resultset->title);
            $noteModel->setBody($resultset->body);
            
            $resultsetUserTagDomain->setId($resultsetUserTagDomain->getId());
            $resultsetUserTagDomain->setUserId($resultsetUserTagDomain->getUserId());
            $resultsetUserTagDomain->setTag($resultsetUserTagDomain->getTag());
            
            $noteCreateModel = array(
                $noteModel,
                $resultsetUserTagDomain
            );
            return $noteCreateModel;
        }
    }
    
    public function delete(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
        	&& $this->validator->validNumber($noteModel->getId())
        	&& $this->validator->notNull($noteModel->getIsDeleted())
        	&& $this->validator->validNumber($noteModel->getIsDeleted())) {
            $noteMapper = new NoteMapper();
            
            $resultset = $noteMapper->delete($noteModel);
            $noteModel->setIsDeleted($resultset->isDeleted);
            return $noteModel;
        }
    }
    
    public function update(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
        	&& $this->validator->validNumber($noteModel->getId())
        	&& $this->validator->notNull($noteModel->getTitle())
        	&& $this->validator->notNull($noteModel->getBody())) {
            $noteMapper = new NoteMapper();
            
            $resultset = $noteMapper->update($noteModel);
            return $resultset;
        }
    }
    
    public function read(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
        	&& $this->validator->validNumber($noteModel->getId())) {
            $noteMapper = new NoteMapper();
            
            $resultset = $noteMapper->read($noteModel);
            
            $noteModel->setId($resultset->id);
            $noteModel->setTitle($resultset->title);
            $noteModel->setBody($resultset->body);
            return $noteModel;
        }
    }
}
