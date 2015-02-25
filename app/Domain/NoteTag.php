<?php

namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\NoteTag as NoteTagMapper;

use Notes\Model\NoteTag as NoteTagModel;

use Notes\Validator\InputValidator as InputValidator;

class NoteTag
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    public function create($noteTagModel)
    {
        
        if ($this->validator->notNull($noteTagModel->getNoteId())
            && $this->validator->validNumber($noteTagModel->getNoteId())
            && $this->validator->notNull($noteTagModel->getUserTagId())
            && $this->validator->validNumber($noteTagModel->getNoteId())) {
            $noteTagMpper = new NoteTagMapper();
            $noteTagModel = $noteTagMpper->create($noteTagModel);
            return $noteTagModel;
        }
    }
    public function read($noteTagModel)
    {
        
        if ($this->validator->notNull($noteTagModel->getId())
            && $this->validator->validNumber($noteTagModel->getId())) {
            $noteTagMpper = new NoteTagMapper();
            $noteTagModel = $noteTagMpper->read($noteTagModel);
            return $noteTagModel;
        }
    }
    public function delete($noteTagModel)
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
