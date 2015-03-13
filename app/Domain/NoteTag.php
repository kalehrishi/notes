<?php

namespace Notes\Domain;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Mapper\NoteTag as NoteTagMapper;

use Notes\Model\NoteTag as NoteTagModel;

use Notes\Validator\InputValidator as InputValidator;

use Notes\Model\UserTag as UserTagModel;
use Notes\Domain\UserTag as UserTag;
use Notes\Collection\Collection as Collection;

class NoteTag
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    public function edit($noteModel, $noteTagModel)
    {
        if ($this->validator->notNull($noteModel->getUserId())
            && $this->validator->notNull($noteTagModel->getNoteId())
            && $this->validator->validNumber($noteTagModel->getNoteId())
            && $this->validator->notNull($noteTagModel->getUserTag())
            && $this->validator->notNull($noteTagModel->getUserTag())) {
            $userTagModel = new UserTagModel();
            $userTagModel->setUserId($noteModel->getUserId());
            $userTagModel->setTag($noteTagModel->getUserTag());

            $noteUserTagDomain = new UserTag();

            $userTagCollection = new Collection();
            $userTagCollection->add($noteUserTagDomain->create($userTagModel));

            $noteTagModel->setUserTagId($userTagCollection->getRow(0)->getId());
            
            $noteTagCollection = new Collection();
            $noteTagMapper = new NoteTagMapper();
            $noteTagCollection->add($noteTagMapper->create($noteTagModel));

            return array($userTagCollection, $noteTagCollection);

        }
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
    public function readAllTag($noteTagModel)
    {
        
        if ($this->validator->notNull($noteTagModel->getNoteId())
            && $this->validator->validNumber($noteTagModel->getNoteId())) {
            $noteTagMpper = new NoteTagMapper();
            $noteTagCollection = $noteTagMpper->read($noteTagModel);
            return $noteTagCollection;
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
