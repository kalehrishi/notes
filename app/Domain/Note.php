<?php
namespace Notes\Domain;

use Notes\Mapper\Note as NoteMapper;
use Notes\Mapper\Notes as NotesMapper;

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
use Notes\Collection\NoteCollection as NoteCollection;
use Notes\Collection\Collection as Collection;

class Note
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    
    public function create(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getTitle())
            && $this->validator->notNull($noteModel->getUserId())
            && $this->validator->validNumber($noteModel->getUserId())) {
            $noteMapper             = new NoteMapper();
            $noteModel     = $noteMapper->create($noteModel);

            $userTagDomain = new UserTagDomain();
            $noteTagDomain = new NoteTagDomain();
            
            $userModel = new UserModel();
            $userModel->setId($noteModel->getUserId());
            $exitTag = $userTagDomain->readTagsByUserId($userModel);
            
            $userTagCollection = new Collection();
            $noteTagCollection = new Collection();
        
            $countTagsLength = $noteModel->getNoteTags()[0]->getCount();

            for ($i=0; $i < $countTagsLength; $i++) {
                if (($noteModel->getNoteTags()[0]->getRow($i)->getTag() != $exitTag->getRow($i)->getTag())) {
                    $userTagModel   = new UserTagModel();
                    $userTagModel->setUserId($noteModel->getUserId());
                    $userTagModel->setTag($noteModel->getNoteTags()[0]->getRow($i)->getTag());
                    $noteTagModel   = new NoteTagModel();
                    $noteTagModel->setNoteId($noteModel->getId());
                    $noteTagCollection->add($noteTagDomain->create($noteTagModel, $userTagModel));
                    $userTagCollection->add($userTagModel);
                }
            }
            $noteModel->setNoteTags(array('noteId' => $noteModel->getId(),
                'userTagModel' => $userTagCollection));
            return $noteModel;
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
            $noteModel  = $noteMapper->update($noteModel);

            $userTagDomain = new UserTagDomain();
            $noteTagDomain = new NoteTagDomain();

            $userModel          = new UserModel();
            $userModel->setId($noteModel->getUserId());
            $exitTag            = $userTagDomain->readTagsByUserId($userModel);
            $noteTagCollection  = new Collection();
            $countTagsLength    = $noteModel->getNoteTags()[1]->getCount();
            for ($i=0; $i < $countTagsLength; $i++) {
                if (($noteModel->getNoteTags()[1]->getRow($i)->getTag() != $exitTag->getRow(0)->getTag())) {
                    $userTagModel = new UserTagModel();
                    $userTagModel->setUserId($noteModel->getUserId());
                    $userTagModel->setTag($noteModel->getNoteTags()[1]->getRow($i)->getTag());
                    $noteTagModel = new NoteTagModel();
                    $noteTagModel->setNoteId($noteModel->getId());
                    $noteTagCollection->add($noteTagDomain->create($noteTagModel, $userTagModel));
                } else {
                    $noteTagModel = new NoteTagModel();
                    $noteTagModel->setNoteId($noteModel->getId());
                    $readnoteTagModel = $noteTagDomain->readAllTag($noteTagModel);
                    $noteTagModel->setId($readnoteTagModel->getRow($i)->getId());
                    $noteTagModel->setUserTagId($userTagModel->getId());
                    $noteTagModel->setNoteId($noteModel->getId());
                    $noteTagCollection->add($noteTagDomain->update($noteTagModel));
                }
            }
                $noteModel->setNoteTags(array('noteId' => $noteModel->getId(), 'userTagModel' => $noteTagCollection));
                return $noteModel;
        }
    }
    
    public function read(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
            && $this->validator->validNumber($noteModel->getId())) {
            $noteMapper = new NoteMapper();
            $noteModel  = $noteMapper->read($noteModel);
            
            $noteTagModel = new NoteTagModel();
            $noteTagModel->setNoteId($noteModel->getId());
            
            $noteTagDomain     = new NoteTagDomain();
            $noteTagcollection = $noteTagDomain->readAllTag($noteTagModel);
            
            $userTagCollection = new Collection();
            for ($i = 0; $i < count($noteTagcollection); $i++) {
                if ($noteTagcollection->getRow($i)->getIsDeleted() != 1) {
                    $userTagModel      = new UserTagModel();
                    $userTagModel->setId($noteTagcollection->getRow($i)->getUserTagId());
                    $userTagModel->setUserId($noteModel->getUserId());
                    $userTagDomain = new UserTagDomain();
                    $userTagCollection->add($userTagDomain->readTagById($userTagModel));
                }
            }
            $noteModel->setNoteTags(array('noteId' => $noteModel->getId(), 'userTagModel' => $userTagCollection));
            return $noteModel;
        }
    }
    
    public function findAllNotesByUserId(UserModel $userModel)
    {
        if ($this->validator->notNull($userModel->getId())
            && $this->validator->validNumber($userModel->getId())) {
            $noteModel = new NoteModel();
            $noteModel->setUserId($userModel->getId());
            $notesMapper    = new NotesMapper();
            $noteCollection = $notesMapper->findAllNotesByUserId($noteModel);
            return $noteCollection;
        }
    }
}
