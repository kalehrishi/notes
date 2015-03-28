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
            $noteMapper    = new NoteMapper();
            $noteModel     = $noteMapper->create($noteModel);
            $userTagDomain = new UserTagDomain();
            $noteTagDomain = new NoteTagDomain();
            
            $userModel = new UserModel();
            $userModel->setId($noteModel->getUserId());
            $existTags          = $userTagDomain->readTagsByUserId($userModel);
            $noteTagCollection = new Collection();
            $userTagCollection = new Collection();
            
            $countExistingTagsLength = $existTags->getCount();
            $i                       = 0;
            if ($noteTagCollection->isEmpty($noteModel->getNoteTag())) {
                $countTagsLength = $noteModel->getNoteTag()->getCount();
                while ($i < $countTagsLength) {
                    $isAlreadyCreated = false;
                    
                    for ($j = 0; $j < $countExistingTagsLength; $j++) {
                        if (($noteModel->getNoteTag()->getRow($i)->getUserTag()->getTag()
                            == $existTags->getRow($j)->getTag())) {
                            $userTagModel = new UserTagModel();
                            $userTagModel->setUserId($existTags->getRow($j)->getUserId());
                            $userTagModel->setId($existTags->getRow($j)->getId());
                            $userTagModel->setTag($existTags->getRow($j)->getTag());
                            $isAlreadyCreated = true;
                            break;
                        }
                    }
                    if ($isAlreadyCreated == false) {
                        $userTagModel = new UserTagModel();
                        $userTagModel->setUserId($noteModel->getUserId());
                        $userTagModel->setTag($noteModel->getNoteTag()->getRow($i)->getUserTag()->getTag());
                        
                        $userTagModel = $userTagDomain->create($userTagModel);
                    }
                    $userTagCollection->add($userTagModel);
                    $noteTagModel = new NoteTagModel();
                    $noteTagModel->setUserTagId($userTagCollection->getRow($i)->getId());
                    $noteTagModel->setUserTag($userTagCollection->getRow($i));
                    $noteTagModel->setNoteId($noteModel->getId());
                    $i++;
                    $noteTagCollection->add($noteTagDomain->create($noteTagModel));
                    
                }
                $noteModel->setNoteTag($noteTagCollection);
            }
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
            $noteModel->setLastUpdatedOn(date("Y-m-d H:i:s"));
            
            $noteTagCollection = new Collection();
            $userTagCollection = new Collection();
            
            $noteModel = $noteMapper->update($noteModel);
            if ($noteModel->getIsDeleted() == 0) {
                $userTagDomain = new UserTagDomain();
                $noteTagDomain = new NoteTagDomain();
                
                $userModel = new UserModel();
                $userModel->setId($noteModel->getUserId());
                $existTags       = $userTagDomain->readTagsByUserId($userModel);
                $countTagsLength = $noteModel->getNoteTag()->getTotal();
                $i               = 0;
                while ($i <= $countTagsLength) {
                    $isAlreadyCreated = true;
                    
                    $userTagModel = new UserTagModel();
                    $userTagModel->setUserId($noteModel->getUserId());
                    $userTagModel->setId($noteModel->getNoteTag()->getRow($i)->getUserTag()->getId());
                    $userTagModel->setTag($noteModel->getNoteTag()->getRow($i)->getUserTag()->getTag());
                    
                    for ($j = 0; $j < count($existTags); $j++) {
                        if (($noteModel->getNoteTag()->getRow($i)->getUserTag()->getTag()
                            != $existTags->getRow($j)->getTag())) {
                            $userTagModel = new UserTagModel();
                            $userTagModel->setUserId($noteModel->getUserId());
                            $userTagModel->setTag($noteModel->getNoteTag()->getRow($i)->getUserTag()->getTag());
                            
                            $userTagModel     = $userTagDomain->create($userTagModel);
                            $isAlreadyCreated = false;
                            break;
                        }
                        
                    }
                    $userTagCollection->add($userTagModel);
                    $noteTagModel = new NoteTagModel();
                    
                    $noteTagModel->setNoteId($noteModel->getId());
                    $noteTagModel->setUserTagId($userTagCollection->getRow($i)->getId());
                    $noteTagModel->setUserTag($userTagCollection->getRow($i));
                    
                    if ($isAlreadyCreated == true) {
                        $noteTagCollection = Note::updateNoteTag($noteModel);
                    } else {
                        $noteTagCollection->add($noteTagDomain->create($noteTagModel));
                    }
                    $i++;
                }
            } else {
                $noteTagCollection = Note::updateNoteTag($noteModel);
            }
            $noteModel->setNoteTag($noteTagCollection);
            return $noteModel;
        }
    }
    public function updateNoteTag($noteModel)
    {
        $noteTagCollection = new Collection();
        $noteTagDomain = new NoteTagDomain();
        $noteTagModel  = new NoteTagModel();
                
        $noteTagModel->setNoteId($noteModel->getId());
        $readAllTagsCollection = $noteTagDomain->readAllTag($noteTagModel);
        for ($i = 0; $i <= $readAllTagsCollection->getTotal(); $i++) {
            $noteTagCollection->add($noteTagDomain->update($readAllTagsCollection->getRow($i)));
        }
        return $noteTagCollection;
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
            $noteModel->setNoteTag($noteTagcollection);
            return $noteModel;
        }
    }
    
    public function findAllNotesByUserId(UserModel $userModel)
    {
        if ($this->validator->notNull($userModel->getId())
            && $this->validator->validNumber($userModel->getId())) {
            $noteModel = new NoteModel();
            $noteModel->setUserId($userModel->getId());
            
            $notesMapper = new NotesMapper();
            $noteModel   = $notesMapper->findAllNotesByUserId($noteModel);
            return $noteModel;
        }
    }
}
