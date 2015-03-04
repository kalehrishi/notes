<?php

namespace Notes\Collection;

use Notes\Model\UserTag as UserTagModel;

class UserTagCollectionTest extends \PHPUnit_Framework_TestCase
{   
    /**
    * @test
    *
    */
    public function it_should_be_added_multiple_object()
    {
         $resulset = array(
         	'0'=>array(
                'id' => 41,
                'userId' => 4,
                'tag' => 'People',
                'isDeleted' => 0
              ),
         	'1'=>array(
                'id' => 122,
                'userId' => 71,
                'tag' => 'Import',
                'isDeleted' => 0
              )
         	);


    	$userTagCollection = new UserTagCollection($resulset);

    	$userTagCollection->rewind();
        while($userTagCollection->hasNext()) {
        $this->assertEquals(122, $userTagCollection->getRow(1)->getId());
        $this->assertEquals(71, $userTagCollection->getRow(1)->getUserId());
        $this->assertEquals('Import', $userTagCollection->getRow(1)->getTag());
        $this->assertEquals(0, $userTagCollection->getRow(1)->getIsDeleted());
        $this->assertEquals(41, $userTagCollection->getRow(0)->getId());
        $this->assertEquals(4, $userTagCollection->getRow(0)->getUserId());
        $this->assertEquals('People', $userTagCollection->getRow(0)->getTag());
        $this->assertEquals(0, $userTagCollection->getRow(0)->getIsDeleted());
        $userTagCollection->next();
        }  
    }
}
