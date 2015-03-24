<?php

namespace Notes\Controller;

use Notes\Model\User as UserModel;
use Notes\Model\Note as NoteModel;
use Notes\Model\NoteTag as NoteTagModel;
use Notes\Domain\Note as NoteDomain;
use Notes\Mapper\NoteTag as NoteTagMapper;


use Notes\Collection\Collection as Collection;
use Notes\Collection\UserTagCollection as UserTagCollection;
use Notes\Collection\NoteTagCollection as NoteTagCollection;


use Notes\Service\User as UserService;

use Notes\Response\Response as Response;


class User
{
    protected $request;
    public $message="Ok";
    public function __construct($request)
    {
        $this->request=$request;
    }
    public function create()
    {
        $data_array=$this->request->getData();
        $data=$data_array['data'];
        $note=$data_array['note'];
        $noteModel = new NoteModel();
        $noteModel->setTitle($note['title']);
        $noteModel->setBody($note['body']);
        echo"----NOTE MODEL--------<br>";
        print_r($noteModel->toArray());

        $userModel = new UserModel();
        $userModel->setFirstName($data['firstName']);
        $userModel->setLastName($data['lastName']);
        $userModel->setEmail($data['email']);
        $userModel->setPassword($data['password']);
        $userModel->setCreatedOn($data['createdOn']);
        try {
        $userService = new UserService();
        $userModel    = $userService->create($userModel);
       
        } catch (\InvalidArgumentException $e ) {
            $this->message=$e->getMessage();
        }
        catch (\Exception $e ) {
            print_r($this->message=$e->getMessage());
        }

        $objResponse= new Response(200,$this->message,"1.0.0",$userModel->toArray());
        return $objResponse->getResponse();
    }

    public function update()
    {
        $data_array=$this->request->get();
        $data=$data_array['data'];

        $userModel = new UserModel();
        $userModel->setId($data['id']);
        $userModel->setFirstName($data['firstName']);
        $userModel->setLastName($data['lastName']);
        $userModel->setEmail($data['email']);
        $userModel->setPassword($data['password']);
        $userModel->setCreatedOn($data['createdOn']);
        try {
        $userService = new UserService();
        $response    = $userService->update($userModel);
        } catch (\InvalidArgumentException $e ) {
             $response=$e->getMessage();
        }
        return $response;
    }

   public function read()
    {
         $noteInput = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteTag = array(
            '0'=>array(
                'id' => 1,
                'noteId' => 3,
                'userTagId' => 1,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 1,
                    'userId' => 1,
                    'tag' => 'OOP PHP',
                    'isDeleted' => 0)
              ),
            '1'=>array(
                'id' => 2,
                'noteId' => 3,
                'userTagId' => 3,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 2,
                    'userId' => 1,
                    'tag' => 'First Tag',
                    'isDeleted' => 0)
              ),
            '2'=>array(
                'id' => 2,
                'noteId' => 3,
                'userTagId' => 4,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 3,
                    'userId' => 1,
                    'tag' => 'Second Tag',
                    'isDeleted' => 0)
              )
            );
        $noteTagCollection = new NoteTagCollection($noteTag);
        
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $noteModel->setNoteTag($noteTagCollection);
        
       
        

        try {
        $noteDomain = new NoteDomain();
        $response  = $noteDomain->create($noteModel);
//print_r($response);
        } catch (\InvalidArgumentException $e ) {
             $response=$e->getMessage();
        }
        //print_r($response->toArray());
        $obj_array=$response->toArray();
        //print_r($obj_array);
        $objResponse= new Response(200,$this->message,"1.0.0",$obj_array);
        return $objResponse->getResponse();
    }
}
