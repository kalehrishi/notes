<?php

namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\NoteTag as NoteTagMapper;
use Notes\Domain\UserTag as UserTagDomain;

use Notes\Model\NoteTag as NoteTagModel;
use Notes\Model\UserTag as UserTagModel;
use Notes\Model\NoteModel as NoteModel;

use Notes\Validator\InputValidator as InputValidator;

class NoteTag
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    public function create(NoteTagModel $noteTagModel)
    {
        if ($noteTagModel->getId() == null) {
            $noteTagMapper = new NoteTagMapper();
            $noteTagModel = $noteTagMapper->create($noteTagModel);
        }
        return $noteTagModel;
    }
    public function readAllTagByNoteId($noteModel)
    {
        $this->validator->notNull($noteModel->getId());
        $this->validator->validNumber($noteModel->getId());
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($noteModel->getId());

        $noteTagMapper      = new NoteTagMapper();
        $noteTagCollection = $noteTagMapper->readByNoteId($noteTagModel);
        $userTagDomain     = new UserTagDomain();
        
        for ($i = 0; $i <= $noteTagCollection->getTotal(); $i++) {
            $userTagModel = new UserTagModel();
            $userTagModel->setId($noteTagCollection->getRow($i)->getUserTagId());
            $userTagModel = $userTagDomain->readTagById($userTagModel);
            $noteTagCollection->getRow($i)->setUserTag($userTagModel);
        }
        return $noteTagCollection;
    }
    public function readByNoteTagId($noteTagModel)
    {
        $this->validator->notNull($noteTagModel->getId());
        $this->validator->validNumber($noteTagModel->getId());

        $noteTagMapper      = new NoteTagMapper();
        $noteTagModel = $noteTagMapper->readByNoteTagId($noteTagModel);
        
        $userTagDomain     = new UserTagDomain();
        $userTagModel = new UserTagModel();
        $userTagModel->setId($noteTagModel->getUserTagId());
        $userTagModel = $userTagDomain->readTagById($userTagModel);

        $noteTagModel->setUserTag($userTagModel);
        return $noteTagModel;
    }
    public function update($noteTagModel)
    {
        $noteTagModel->setIsDeleted(1);
        
        $this->validator->notNull($noteTagModel->getNoteId());
        $this->validator->validNumber($noteTagModel->getNoteId());
        $this->validator->notNull($noteTagModel->getId());
        $this->validator->validNumber($noteTagModel->getId());
        $this->validator->validNumber($noteTagModel->getUserTagId());
        
        $noteTagMapper = new NoteTagMapper();
        $noteTagModel = $noteTagMapper->update($noteTagModel);
        return $noteTagModel;
    }
    
    public function save(NoteTagModel $noteTagModel)
    {
        $userTagModel  = new UserTagModel();
        $userTagDomain = new UserTagDomain();
        
        if ($noteTagModel->getId() != null) {
            $noteTagModel->setId($noteTagModel->getId());
            $noteTagModel->setNoteId($noteTagModel->getNoteId());
            $noteTagModel->setUserTagId($noteTagModel->getUserTagId());
            $noteTagModel->setUserTag($noteTagModel->getUserTag());
            
            $noteTagModel = $this->update($noteTagModel);
        } else {
            $userTagModel->setId($noteTagModel->getUserTag()->getId());
            $userTagModel->setUserId($noteTagModel->getUserTag()->getUserId());
            $userTagModel->setTag($noteTagModel->getUserTag()->getTag());
            
            $userTagModel = $userTagDomain->create($userTagModel);
            
            $noteTagModel->setId($noteTagModel->getId());
            $noteTagModel->setUserTagId($userTagModel->getId());
            $noteTagModel->setUserTag($userTagModel);
            $noteTagModel->setNoteId($noteTagModel->getNoteId());
            $noteTagModel = $this->create($noteTagModel);
        }
        return $noteTagModel;
    }
}
