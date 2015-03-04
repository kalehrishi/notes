<?php
namespace Notes\Domain;

use Notes\Mapper\Note as NoteMapper;
use Notes\Model\Note as NoteModel;

use Notes\Config\Config as Configuration;

use Notes\Validator\InputValidator as InputValidator;

use Notes\Domain\UserTag as UserTagDomain;
use Notes\Model\UserTag as UserTagModel;

use Notes\Domain\NoteTag as NoteTagDomain;
use Notes\Model\NoteTag as NoteTagModel;

use Notes\Model\User as UserModel;
use Notes\Domain\User as UserDomain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class Note
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    public function create(NoteModel $noteModel, $tagsInput)
    {
        if ($this->validator->notNull($noteModel->getTitle())) {
            $userDomain = new UserDomain();
            $userModel  = new UserModel();
            $userModel->setId($noteModel->getUserId());
            $resultsetUserModel = $userDomain->read($userModel);
            $noteModel->setUserId($resultsetUserModel->getId());
            
            $noteMapper            = new NoteMapper();
            $resultsetNoteModel    = $noteMapper->create($noteModel);
            $resultsetUserTagModel = array();
            $resultsetNoteTagModel = array();
            if (!empty($tagsInput)) {
                for ($i = 0; $i < count($tagsInput); $i++) {
                    $userTagModel = new UserTagModel();
                    $userTagModel->setUserId($resultsetUserModel->getId());
                    $userTagModel->setTag($tagsInput[$i]);
                    
                    $userTagDomain = new UserTagDomain();
                    array_push($resultsetUserTagModel, $userTagDomain->create($userTagModel));
                    $noteTagModel = new NoteTagModel();
                    $noteTagModel->setNoteId($resultsetNoteModel->getId());
                    $noteTagModel->setUserTagId($resultsetUserTagModel[$i]->getId());
                    
                    
                    $noteTagDomain = new NoteTagDomain();
                    array_push($resultsetNoteTagModel, $noteTagDomain->create($noteTagModel));
                }
            } else {
                return $noteModel;
            }
            $resultsetNoteCreateModel = array(
                $resultsetNoteModel,
                $resultsetUserTagModel,
                $resultsetNoteTagModel
            );
            return $resultsetNoteCreateModel;
        }
    }
    
    public function delete(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
        	&& $this->validator->validNumber($noteModel->getId())
        	&& $this->validator->notNull($noteModel->getIsDeleted())
        	&& $this->validator->validNumber($noteModel->getIsDeleted())) {
            $noteMapper               = new NoteMapper();
            $resultsetNoteDeleteModel = $noteMapper->delete($noteModel);
            return $resultsetNoteDeleteModel;
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
    
    public function readNote($noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
        	&& $this->validator->validNumber($noteModel->getId())) {
            $noteMapper = new NoteMapper();
            $resultset  = $noteMapper->read($noteModel);
            $noteModel  = array();
            for ($i = 0; $i < count($resultset); $i++) {
                array_push($noteModel, $resultset[$i]);
            }
            return $noteModel;
        }
        
    }
    
    public function readAllNotes(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getUserId())
        	&& $this->validator->validNumber($noteModel->getUserId())) {
            $noteMapper = new NoteMapper();
            $resultset  = $noteMapper->read($noteModel);
            $noteModel  = array();
            for ($i = 0; $i < count($resultset); $i++) {
                array_push($noteModel, $resultset[$i]);
            }
            return $noteModel;
            
        }
    }
}
