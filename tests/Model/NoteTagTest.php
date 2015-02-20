<?php
namespace Notes\Model;

use Notes\Mapper\NoteTag as NoteTagMapper;

class NoteTagTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetAndAccessMultipleProperties()
    {
        
        $input   = array(
            'id' => 125,
            'noteId' => 48,
            'userTagId' => 25
        );
        $noteTag = new NoteTag();
        $noteTag->setId($input['id']);
        $noteTag->setNoteId($input['noteId']);
        $noteTag->setUserTagId($input['userTagId']);
        
        $this->assertEquals(125, $noteTag->getId());
        $this->assertEquals(48, $noteTag->getNoteId());
        $this->assertEquals(25, $noteTag->getuserTagId());
        
        
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
