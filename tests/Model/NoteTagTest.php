<?php
namespace Notes\Model;

use Notes\Mapper\NoteTag as NoteTagMapper;
use Notes\Model\UserTag as UserTag;

class NoteTagTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetAndAccessMultipleProperties()
    {
        
        $input   = array(
            'id' => 125,
            'noteId' => 48,
            'userTagId' => 25,
            'isDeleted' => 1,
            'userTag' => 'Javascript'
        );
        $noteTag = new NoteTag();
        $noteTag->setId($input['id']);
        $noteTag->setNoteId($input['noteId']);
        $noteTag->setUserTagId($input['userTagId']);
        $noteTag->setIsDeleted($input['isDeleted']);
        
        $userTag = new UserTag();
        $userTag->setTag($input['userTag']);

        $this->assertEquals(125, $noteTag->getId());
        $this->assertEquals(48, $noteTag->getNoteId());
        $this->assertEquals(25, $noteTag->getuserTagId());
        $this->assertEquals(1, $noteTag->getIsDeleted());
        
        $this->assertEquals('Javascript', $userTag->getTag());
        
    }
    public function testCanSetAndAccessSingleProperty()
    {
        $input   = array(
            'noteId' => 1
        );
        $noteTag = new NoteTag();
        $noteTag->setNoteId($input['noteId']);
        
        $this->assertEquals(1, $noteTag->getNoteId());
    }
}
