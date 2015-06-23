<?php
namespace Notes\Model;

use Notes\Mapper\NoteTag as NoteTagMapper;
use Notes\Model\UserTag as UserTag;

class NoteTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     *@test
     *
     **/
    public function it_should_set_multiple_properties()
    {
        
        $noteTagInput   = array(
            'id' => 125,
            'noteId' => 48,
            'userTagId' => 25,
            'isDeleted' => 1,
            'userTag' => 'Javascript'
        );
        $noteTagModel = new NoteTag();
        $noteTagModel->setId($noteTagInput['id']);
        $noteTagModel->setNoteId($noteTagInput['noteId']);
        $noteTagModel->setUserTagId($noteTagInput['userTagId']);
        $noteTagModel->setIsDeleted($noteTagInput['isDeleted']);
        
        $userTagModel = new UserTag();
        $userTagModel->setTag($noteTagInput['userTag']);
        
        $this->assertEquals(125, $noteTagModel->getId());
        $this->assertEquals(48, $noteTagModel->getNoteId());
        $this->assertEquals(25, $noteTagModel->getuserTagId());
        $this->assertEquals(1, $noteTagModel->getIsDeleted());
        
        $this->assertEquals('Javascript', $userTagModel->getTag());
        
    }
    /**
     *@test
     *
     **/
    public function it_should_set_single_property()
    {
        $noteTagInput   = array(
            'noteId' => 1
        );
        $noteTagModel = new NoteTag();
        $noteTagModel->setNoteId($noteTagInput['noteId']);
        
        $this->assertEquals(1, $noteTagModel->getNoteId());
    }
    /**
     *@test
     *
     **/
    public function it_should_convert_object_into_array()
    {
        $noteTagInput = array(
            'id' => 125,
            'noteId' => 48,
            'userTagId' => 25,
            'isDeleted' => 1,
            'userTag' => array(
                'id' => 1,
                'userId' => 2,
                'tag' => 'People',
                'isDeleted' => 1
            )
        );
        $noteTagModel = new NoteTag();
        $noteTagModel->setId($noteTagInput['id']);
        $noteTagModel->setNoteId($noteTagInput['noteId']);
        $noteTagModel->setUserTagId($noteTagInput['userTagId']);
        $noteTagModel->setIsDeleted($noteTagInput['isDeleted']);
        $noteTagModel->setIsDeleted($noteTagInput['isDeleted']);
        
        $userTagModel = new UserTag();
        $userTagModel->setId($noteTagInput['userTag']['id']);
        $userTagModel->setUserId($noteTagInput['userTag']['userId']);
        $userTagModel->setTag($noteTagInput['userTag']['tag']);
        $userTagModel->setIsDeleted($noteTagInput['userTag']['isDeleted']);
        
        $noteTagModel->setUserTag($userTagModel);
        
        $this->assertEquals($noteTagInput, $noteTagModel->toArray());
    }
}
