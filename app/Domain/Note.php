<?php
namespace Notes\Domain;

use Notes\Mapper\Note as NoteMapper;
use Notes\Model\Note as NoteModel;
use Notes\Config\Config as Configuration;

class Note
{
	public function create($input)
	{
		$noteMapper 	= 	new NoteMapper();
		$noteModel 		=	 new NoteModel($input);
		$resultset 		= 	$noteMapper->create($noteModel);
		
		$noteModel->id 	= 	$resultset->id;
		$noteModel->userId 	= 	$resultset->userId;
		$noteModel->title 	= 	$resultset->title;
		$noteModel->body 	=	$resultset->body;
		return $noteModel;
	}

	public function delete($input)
	{
		$noteMapper 	= 	new NoteMapper();
		$noteModel 		=	 new NoteModel($input);
		$resultset 		= 	$noteMapper->delete($noteModel);
		$noteModel->isDeleted = $resultset->isDeleted;
		return $noteModel;

	}

	public function update($input)
	{
		$noteMapper 	= 	new NoteMapper();
		$noteModel 		=	 new NoteModel($input);
		$resultset 		= 	$noteMapper->update($noteModel);
		return $resultset;
	}

	public function read($input)
	{
		$noteMapper 	= 	new NoteMapper();
		$noteModel 		=	 new NoteModel($input);
		$resultset 		= 	$noteMapper->read($noteModel);
		$noteModel->id = $resultset->id;
		$noteModel->title = $resultset->title;
		$noteModel->body = $resultset->body;
		return $noteModel;
	}
}
