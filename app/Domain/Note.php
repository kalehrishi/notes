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
        $this->validator->notNull($noteModel->getTitle());
        $this->validator->notNull($noteModel->getUserId());
        $this->validator->validNumber($noteModel->getUserId());
        
        $noteMapper    = new NoteMapper();
        $noteModel     = $noteMapper->create($noteModel);
        $userTagDomain = new UserTagDomain();
        $noteTagDomain = new NoteTagDomain();
        
        $userModel = new UserModel();
        $userModel->setId($noteModel->getUserId());
        $existTags         = $userTagDomain->readTagsByUserId($userModel);
        $noteTagCollection = new Collection();
        $userTagCollection = new Collection();
        
        $countExistingTagsLength = $existTags->getCount();
        if ($noteTagCollection->isEmpty($noteModel->getNoteTags())) {
            $countTagsLength = $noteModel->getNoteTags()->getCount();
            for ($i = 0; $i < $countTagsLength; $i++) {
                $isAlreadyCreated = false;
                
                for ($j = 0; $j < $countExistingTagsLength; $j++) {
                    if (($noteModel->getNoteTags()->getRow($i)->getUserTag()->getTag()
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
                    $userTagModel->setTag($noteModel->getNoteTags()->getRow($i)->getUserTag()->getTag());
                    
                    $userTagModel = $userTagDomain->create($userTagModel);
                }
                $userTagCollection->add($userTagModel);
                $noteTagModel = new NoteTagModel();
                $noteTagModel->setUserTagId($userTagCollection->getRow($i)->getId());
                $noteTagModel->setUserTag($userTagCollection->getRow($i));
                $noteTagModel->setNoteId($noteModel->getId());
                
                $noteTagCollection->add($noteTagDomain->create($noteTagModel));
                
            }
            $noteModel->setNoteTags($noteTagCollection);
        }
        return $noteModel;
        
    }
    
    public function update(NoteModel $noteModel)
    {
        $this->validator->notNull($noteModel->getId());
        $this->validator->validNumber($noteModel->getId());
        $this->validator->notNull($noteModel->getTitle());
        $this->validator->notNull($noteModel->getBody());
        $noteMapper = new NoteMapper();

        $noteModel->setLastUpdatedOn(date("Y-m-d H:i:s"));
        $noteModel  = $noteMapper->update($noteModel);
        
        $userTagDomain = new UserTagDomain();
        $noteTagDomain = new NoteTagDomain();
        
        $noteTagCollection = new Collection();
        
        if ($noteModel->getIsDeleted() == 0) {
            $countTagsLength = $noteModel->getNoteTags()->getCount();
            for ($i = 0; $i < $countTagsLength; $i++) {
                if ($noteTagCollection->isEmpty($noteModel->getNoteTags()->getRow($i)->getId())) {
                    $noteTagModel = new NoteTagModel();
                    $noteTagModel->setId($noteModel->getNoteTags()->getRow($i)->getId());
                    $noteTagModel->setNoteId($noteModel->getNoteTags()->getRow($i)->getNoteId());
                    $noteTagModel->setUserTagId($noteModel->getNoteTags()->getRow($i)->getUserTagId());
                    $noteTagModel->setUserTag($noteModel->getNoteTags()->getRow($i)->getUserTag());
                    
                    $noteTagCollection->add($noteTagDomain->update($noteTagModel));
                } else {
                    if ($noteTagCollection->isEmpty($noteModel->getNoteTags()->getRow($i)->getUserTag()->getId())) {
                        $noteTagModel = new NoteTagModel();
                        
                        $noteTagModel->setUserTagId($noteModel->getNoteTags()->getRow($i)->getUserTag()->getId());
                        $noteTagModel->setUserTag($noteModel->getNoteTags()->getRow($i)->getUserTag());
                        
                    } else {
                        $userTagModel = new UserTagModel();
                        
                        $userTagModel->setUserId($noteModel->getUserId());
                        $userTagModel->setTag($noteModel->getNoteTags()->getRow($i)->getUserTag()->getTag());
                        
                        $userTagModel = $userTagDomain->create($userTagModel);

                        $noteTagModel = new NoteTagModel();
                        $noteTagModel->setUserTagId($userTagModel->getId());
                        $noteTagModel->setUserTag($userTagModel);
                        
                    }
                    $noteTagModel->setNoteId($noteModel->getId());
                    $noteTagCollection->add($noteTagDomain->create($noteTagModel));
                }
            }
        }
        
        $noteModel->setNoteTags($noteTagCollection);
        return $noteModel;
        
    }
    
    public function read(NoteModel $noteModel)
    {
        $this->validator->notNull($noteModel->getId());
        $this->validator->validNumber($noteModel->getId());
        $noteMapper = new NoteMapper();
        $noteModel  = $noteMapper->read($noteModel);
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($noteModel->getId());
        
        $noteTagDomain     = new NoteTagDomain();
        $noteTagcollection = $noteTagDomain->readAllTag($noteTagModel);
        $noteModel->setNoteTags($noteTagcollection);
        return $noteModel;
    }
    
    public function findAllNotesByUserId(UserModel $userModel)
    {
        $this->validator->notNull($userModel->getId());
        $this->validator->validNumber($userModel->getId());
        $noteModel = new NoteModel();
        $noteModel->setUserId($userModel->getId());
        
        $notesMapper = new NotesMapper();
        $noteModel   = $notesMapper->findAllNotesByUserId($noteModel);
        return $noteModel;
    }
}
