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
    
    public function create(NoteModel $noteModel)
    {
        if ($this->validator->notNull($noteModel->getUserId())
        	&& $this->validator->validNumber($noteModel->getUserId())
        	&& $this->validator->notNull($noteModel->getTitle())
        	&& $this->validator->notNull($noteModel->getBody())) {
            $noteMapper            = new NoteMapper();
            $resultsetNoteModel    = $noteMapper->create($noteModel);
            $userTagInput          = array(
                0 => array(
                    'userId' => $resultsetNoteModel->getUserId(),
                    'tag' => 'PHP'
                ),
                1 => array(
                    'userId' => $resultsetNoteModel->getUserId(),
                    'tag' => 'PHP6'
                )
            );
            $count                 = count($userTagInput);
            $resultsetUserTagModel = array();
            for ($i = 0; $i < $count; $i++) {
                $userTagModel = new UserTagModel();
                
                $userTagModel->setUserId($userTagInput[$i]['userId']);
                $userTagModel->setTag($userTagInput[$i]['tag']);
                
                $noteUserTagDomain = new UserTagDomain();
                array_push($resultsetUserTagModel, $noteUserTagDomain->create($userTagModel));
                
                
            }
            $c1                   = count($resultsetUserTagModel);
            $resultsetNotTagModel = array();
            for ($i = 0; $i < $c1; $i++) {
                $noteTagModel = new NoteTagModel();
                $noteTagModel->setNoteId($resultsetNoteModel->getId());
                $noteTagModel->setUserTagId($resultsetUserTagModel[$i]->getId());
                
                $noteTagDomain = new NoteTagDomain();
                array_push($resultsetNotTagModel, $noteTagDomain->create($noteTagModel));
                
                
                
            }
            $resultsetNoteCreateModel = array(
                $resultsetNoteModel,
                $resultsetUserTagModel,
                $resultsetNotTagModel
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
        $noteMapper = new NoteMapper();
        
        $resultset = $noteMapper->read($noteModel);
        $noteModel = array();
        for ($i = 0; $i < count($resultset); $i++) {
            array_push($noteModel, $resultset[$i]);
        }
        return $noteModel;
    }
    
    public function read(NoteModel $noteModel, $flag)
    {
        if ($flag) {
            if ($this->validator->notNull($noteModel->getUserId())
            	&& $this->validator->validNumber($noteModel->getUserId())) {
                $noteModel = Note::readNote($noteModel);
            }
        } else {
            if ($this->validator->notNull($noteModel->getId())
            	&& $this->validator->validNumber($noteModel->getId())) {
                $noteModel = Note::readNote($noteModel);
            }
        }
        return $noteModel;
    }
}
