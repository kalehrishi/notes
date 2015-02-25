<?php
namespace Notes\Domain;

use Notes\Mapper\Note as NoteMapper;
use Notes\Model\Note as NoteModel;
use Notes\Config\Config as Configuration;
use Notes\validator\InputValidator as InputValidator;

class Note
{
    public function __construct()
    {
        $this->validator = new InputValidator();
    }
    
    public function create($input)
    {
        if ($this->validator->notNull($input['userId']) && $this->validator->validNumber($input['userId'])
        	&& $this->validator->notNull($input['title']) && $this->validator->notNull($input['body'])) {
            $noteMapper = new NoteMapper();
            $noteModel  = new NoteModel($input);
            $resultset  = $noteMapper->create($noteModel);
            
            $noteModel->id     = $resultset->id;
            $noteModel->userId = $resultset->userId;
            $noteModel->title  = $resultset->title;
            $noteModel->body   = $resultset->body;
            return $noteModel;
        }
    }
    
    public function delete($input)
    {
        if ($this->validator->notNull($input['id']) && $this->validator->validNumber($input['id'])
        	&& $this->validator->notNull($input['isDeleted']) && $this->validator->validNumber($input['isDeleted'])) {
            $noteMapper           = new NoteMapper();
            $noteModel            = new NoteModel($input);
            $resultset            = $noteMapper->delete($noteModel);
            $noteModel->isDeleted = $resultset->isDeleted;
            return $noteModel;
        }
    }
    
    public function update($input)
    {
        if ($this->validator->notNull($input['id']) && $this->validator->validNumber($input['id'])
        	&& $this->validator->notNull($input['title']) && $this->validator->notNull($input['body'])) {
            $noteMapper = new NoteMapper();
            $noteModel  = new NoteModel($input);
            $resultset  = $noteMapper->update($noteModel);
            return $resultset;
        }
    }
    
    public function read($input)
    {
        if ($this->validator->notNull($input['id']) && $this->validator->validNumber($input['id'])) {
            $noteMapper       = new NoteMapper();
            $noteModel        = new NoteModel($input);
            $resultset        = $noteMapper->read($noteModel);
            $noteModel->id    = $resultset->id;
            $noteModel->title = $resultset->title;
            $noteModel->body  = $resultset->body;
            return $noteModel;
        }
    }
}
