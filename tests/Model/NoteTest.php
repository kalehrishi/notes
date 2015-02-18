<?php
namespace Notes\Model;

class NoteTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateObject()
    {
        $note = new Note();
        $this->assertInstanceOf('Notes\Model\Note', $note);
    }
}
