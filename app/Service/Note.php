<?php

namespace Notes\Service;

use Notes\Domain\Note  as NoteDomain;
use Notes\Model\Note as NoteModel;

class Note
{
  
    public function __construct()
    {
    
    }
    public function create($request)
    {
    	$noteModel=new NoteModel();
    	$noteModel->setUserId($_COOKIE['userId']);
    	$noteModel->setTitle($request['title']);
    	$noteModel->setBody($request['body']);
        $noteDomain=new NoteDomain();
        
        $response=$noteDomain->create($noteModel);

        return $response;

    }
}
