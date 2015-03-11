<?php
namespace Notes\Domain;

use Notes\Mapper\Note as NoteMapper;
use Notes\Mapper\FindNotes as FindNotesMapper;

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
    
    public function create(NoteModel $noteModel, $tagsInput = null)
    {
        if ($this->validator->notNull($noteModel->getTitle())) {
            $userModel  = new UserModel();
            $userModel->setId($noteModel->getUserId());
            
            $userDomain = new UserDomain();
            $resultsetUserModel = $userDomain->read($userModel);
            $noteModel->setUserId($resultsetUserModel->getId());
            
            $noteMapper            = new NoteMapper();
            $resultsetNoteModel    = $noteMapper->create($noteModel);
            $collectionUserTagModel = new Collection();
            $collectionNoteTagModel = new Collection();
            if (!empty($tagsInput)) {
                for ($i = 0; $i < count($tagsInput); $i++) {
                    $userTagModel = new UserTagModel();
                    $userTagModel->setUserId($resultsetUserModel->getId());
                    $userTagModel->setTag($tagsInput[$i]);
                    
                    $userTagDomain = new UserTagDomain();
                    $collectionUserTagModel->add($userTagDomain->create($userTagModel));
                    $noteTagModel = new NoteTagModel();
                    $noteTagModel->setNoteId($resultsetNoteModel->getId());
                    $noteTagModel->setUserTagId($collectionUserTagModel->getRow($i)->getId());
                    
                    
                    $noteTagDomain = new NoteTagDomain();
                    $collectionNoteTagModel->add($noteTagDomain->create($noteTagModel));
                    
                }
            } else {
                return $resultsetNoteModel;
            }
            return array(
                $resultsetNoteModel,
                $collectionUserTagModel,
                $collectionNoteTagModel
            );
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
    
    public function read(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getId())
            && $this->validator->validNumber($noteModel->getId())) {
            $noteMapper     = new NoteMapper();
            $noteModel = $noteMapper->read($noteModel);
            return $noteModel;
        }
    }
    
    public function findAllNotesByUserId(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getUserId())
            && $this->validator->validNumber($noteModel->getUserId())) {
            $findNotesMapper     = new FindNotesMapper();
            $noteCollection = $findNotesMapper->findAllNotesByUserId($noteModel);
            return $noteCollection;
        }
    }
}
