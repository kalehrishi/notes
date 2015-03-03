<?php

namespace Notes\Collection;

use Notes\Mapper\NoteTag as NoteTagMapper;

use Notes\Model\NoteTag as NoteTagModel;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function test_Add_Single_Array()
    {
        $resultset  = array(
            'name' => 'amit',
            'age' => 11
        );
        $collection = new Collection($resultset);
        $collection->add($resultset);
        
        while (($result = $collection->next())) {
            $this->assertEquals(array(
                'name' => 'amit',
                'age' => 11
            ), $result);
        }
    }
    public function test_Add_Single_Object()
    {
        $noteTagModel = new NoteTagModel();
        
        $noteTagModel->setId(1);
        $noteTagModel->setNoteId(4);
        $noteTagModel->setUserTagId(3);
        $noteTagModel->setIsDeleted(0);
        
        $collection = new Collection();
        $collection->add($noteTagModel);
        
        
        while (($result = $collection->next())) {
            $this->assertEquals($noteTagModel, $result);
        }
    }
    public function test_Add_Two_Object()
    {
        $noteTagModel  = new NoteTagModel();
        $noteTagModel1 = new NoteTagModel();
        
        $collection = new Collection();
        
        $noteTagModel->setId(1);
        $noteTagModel->setNoteId(4);
        $noteTagModel->setUserTagId(3);
        $noteTagModel->setIsDeleted(0);
        
        
        $collection->add($noteTagModel);
        
        $noteTagModel1->setId(2);
        $noteTagModel1->setNoteId(4);
        $noteTagModel1->setUserTagId(3);
        $noteTagModel1->setIsDeleted(0);
        
        $collection->add($noteTagModel1);
        
        $this->assertEquals($noteTagModel, $collection->getRow(0));
        $this->assertEquals($noteTagModel1, $collection->getRow(1));
        
    }
    public function test_Retrives_Collection_Object()
    {
        $collection = new Collection();
        
        $noteTagModel  = new NoteTagModel();
        $noteTagModel->setId(41);
        $noteTagModel->setNoteId(4);
        $noteTagModel->setUserTagId(543);
        $noteTagModel->setIsDeleted(0);
        
        
        $collection->add($noteTagModel);
        
        $noteTagModel->setId(122);
        $noteTagModel->setNoteId(71);
        $noteTagModel->setUserTagId(63);
        $noteTagModel->setIsDeleted(0);
        
        $collection->add($noteTagModel);
        
        while($result=$collection->next())
        {
            print_r($result);
        }
    }
}
