<?php

namespace Notes\Collection;

use Notes\Mapper\NoteTag as NoteTagMapper;

use Notes\Model\NoteTag as NoteTagModel;

class CollectionTest extends \PHPUnit_Framework_TestCase
{   
    private $collection;

    public function setUp()
    {
        $this->collection = new Collection();
    }
    /**
    * @test
    *
    **/
    public function it_should_be_added_single_object()
    {
        $noteTagModel = new NoteTagModel();
        
        $noteTagModel->setId(1);
        $noteTagModel->setNoteId(4);
        $noteTagModel->setUserTagId(3);
        $noteTagModel->setIsDeleted(0);
        
        
        $this->collection->add($noteTagModel);
        
        
        while (($result = $this->collection->next())) {
            $this->assertEquals($noteTagModel, $result);
        }
    }
    /**
    * @test
    * @expectedException         InvalidArgumentException
    * @expectedExceptionMessage  Input should be Object
    **/
    
    public function throws_Exception_when_added_an_array()
    {
        $array=array(
            'test'=>'test',
            'variables'=>3
            );
        $this->collection->add($array);
    }
    /**
    * @test
    *
    **/
    public function it_should_be_added_multiple_objects()
    {
        $noteTagModel  = new NoteTagModel();
        $noteTagModel->setId(41);
        $noteTagModel->setNoteId(4);
        $noteTagModel->setUserTagId(543);
        $noteTagModel->setIsDeleted(0);
        
        $this->collection->add($noteTagModel);

        $this->assertEquals($noteTagModel, $this->collection->getResult(0));
        
        $noteTagModel  = new NoteTagModel();
        $noteTagModel->setId(122);
        $noteTagModel->setNoteId(71);
        $noteTagModel->setUserTagId(63);
        $noteTagModel->setIsDeleted(0);
       
        $this->collection->add($noteTagModel);
        
        $this->assertEquals($noteTagModel, $this->collection->getResult(1));
              
        $noteTagModel  = new NoteTagModel();
        $noteTagModel->setId(12);
        $noteTagModel->setNoteId(1);
        $noteTagModel->setUserTagId(93);
        $noteTagModel->setIsDeleted(1);
        
        $this->collection->add($noteTagModel);
        
        $this->assertEquals($noteTagModel, $this->collection->getResult(2));  


        $this->collection->rewind();
        while(($result = $this->collection->valid())) {
           $this->assertEquals(true,$result);
           $this->collection->next();
        }   

        $this->collection->rewind();
        while($this->collection->hasNext()) {
        $this->assertEquals(122, $this->collection->getResult(1)->getId());
        $this->assertEquals(71, $this->collection->getResult(1)->getNoteId());
        $this->assertEquals(63, $this->collection->getResult(1)->getUserTagId());
        $this->assertEquals(0, $this->collection->getResult(1)->getIsDeleted());
        $this->assertEquals(41, $this->collection->getResult(0)->getId());
        $this->assertEquals(4, $this->collection->getResult(0)->getNoteId());
        $this->assertEquals(543, $this->collection->getResult(0)->getUserTagId());
        $this->assertEquals(0, $this->collection->getResult(0)->getIsDeleted());
        $this->assertEquals(12, $this->collection->getResult(2)->getId());
        $this->assertEquals(1, $this->collection->getResult(2)->getNoteId());
        $this->assertEquals(93, $this->collection->getResult(2)->getUserTagId());
        $this->assertEquals(1, $this->collection->getResult(2)->getIsDeleted());
        $this->collection->next();
        }
    }
}
