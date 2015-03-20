<?php

namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\NoteTag as NoteTagMapper;
use Notes\Mapper\UserTag as UserTagDomain;

use Notes\Model\NoteTag as NoteTagModel;
use Notes\Model\UserTag as UserTagModel;

use Notes\Validator\InputValidator as InputValidator;

class NoteTag
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    public function create(NoteTagModel $noteTagModel)
    {
        if ($this->validator->notNull($noteTagModel->getNoteId())
            && $this->validator->validNumber($noteTagModel->getNoteId())) {
            $noteTagMpper = new NoteTagMapper();
            $noteTagModel = $noteTagMpper->create($noteTagModel);

            return $noteTagModel;
        }
    }
    public function readAllTag($noteTagModel)
    {
        if ($this->validator->notNull($noteTagModel->getNoteId())
            && $this->validator->validNumber($noteTagModel->getNoteId())) {
            $noteTagMpper = new NoteTagMapper();
            $noteTagcollection = $noteTagMpper->read($noteTagModel);
            $userTagDomain = new UserTagDomain();
            for ($i=0; $i < count($noteTagcollection); $i++) {
                $userTagModel = new UserTagModel();
                $userTagModel->setId($noteTagcollection->getRow($i)->getUserTagId());
                $userTagResultSet = $userTagDomain->readTagById($userTagModel);
                $noteTagcollection->getRow($i)->setUserTag($userTagResultSet);
            }
            return $noteTagcollection;
        }
    }
    public function update($noteTagModel)
    {
        $noteTagModel->setIsDeleted(1);
        if ($this->validator->notNull($noteTagModel->getId())
            && $this->validator->validNumber($noteTagModel->getId())
            && $this->validator->notNull($noteTagModel->getNoteId())
            && $this->validator->validNumber($noteTagModel->getNoteId())
            && $this->validator->notNull($noteTagModel->getUserTagId())
            && $this->validator->validNumber($noteTagModel->getUserTagId())) {
            $noteTagMpper = new NoteTagMapper();
            $noteTagModel = $noteTagMpper->update($noteTagModel);
            return $noteTagModel;
        }
    }
}
