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

class Note
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    public function create(NoteModel $noteModel, UserTagModel $userTagModel, NoteTagModel $noteTagModel)
    {
        if ($this->validator->notNull($noteModel->getUserId())
        	&& $this->validator->validNumber($noteModel->getUserId())
        	&& $this->validator->notNull($noteModel->getTitle())
        	&& $this->validator->notNull($noteModel->getBody())) {
            $noteTagDomain         = new NoteTagDomain();
            $resultsetNotTagDomain = $noteTagDomain->create($noteTagModel);
            
            $noteUserTagDomain      = new UserTagDomain();
            $resultsetUserTagDomain = $noteUserTagDomain->create($userTagModel);
            
            $noteMapper          = new NoteMapper();
            $resultsetNoteDomain = $noteMapper->create($noteModel);
            
            $resultsetNoteCreateModel = array(
                $resultsetNoteDomain,
                $resultsetUserTagDomain,
                $resultsetNotTagDomain
            );
            return $resultsetNoteCreateModel;
        }
    }
    
    public function delete(NoteModel $noteModel, NoteTagModel $noteTagModel)
    {
        if ($this->validator->notNull($noteModel->getId())
        	&& $this->validator->validNumber($noteModel->getId())
        	&& $this->validator->notNull($noteModel->getIsDeleted())
        	&& $this->validator->validNumber($noteModel->getIsDeleted())) {
            $noteMapper          = new NoteMapper();
            $resultsetNoteDomain = $noteMapper->delete($noteModel);
            
            $noteTagDomain         = new NoteTagDomain();
            $resultsetNotTagDomain = $noteTagDomain->delete($noteTagModel);
            
            $resultsetNoteDeleteModel = array(
                $resultsetNoteDomain,
                $resultsetNotTagDomain
            );
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
