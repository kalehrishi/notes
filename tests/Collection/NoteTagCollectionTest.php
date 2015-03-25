<?php

namespace Notes\Collection;

use Notes\Model\NoteTag as NoteTagModel;

class NoteTagCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    public function it_should_be_added_multiple_object()
    {
        $resulset = array(
            '0' => array(
                'id' => 41,
                'noteId' => 4,
                'userTagId' => 56,
                'isDeleted' => 0
            ),
            '1' => array(
                'id' => 122,
                'noteId' => 71,
                'userTagId' => 88,
                'isDeleted' => 0
            )
        );
        
        
        $noteTagCollection = new NoteTagCollection($resulset);
        
        $noteTagCollection->rewind();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(122, $noteTagCollection->getRow(1)->getId());
            $this->assertEquals(71, $noteTagCollection->getRow(1)->getNoteId());
            $this->assertEquals(88, $noteTagCollection->getRow(1)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(1)->getIsDeleted());
            $this->assertEquals(41, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(4, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(56, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getIsDeleted());
            $noteTagCollection->next();
        }
    }
    /**
     *@test
     *
     **/
    public function it_should_convert_object_into_array()
    {
        $noteTagInput      = array(
            '0' => array(
                'id' => 1,
                'noteId' => 3,
                'userTagId' => 1,
                'isDeleted' => 0,
                'userTag' => null
            ),
            '1' => array(
                'id' => 2,
                'noteId' => 3,
                'userTagId' => 3,
                'isDeleted' => 0,
                'userTag' => null
            ),
            '2' => array(
                'id' => 2,
                'noteId' => 3,
                'userTagId' => 4,
                'isDeleted' => 0,
                'userTag' => null
            )
        );
        $noteTagCollection = new NoteTagCollection($noteTagInput);
        $this->assertEquals($noteTagInput, $noteTagCollection->toArray());
    }
}
