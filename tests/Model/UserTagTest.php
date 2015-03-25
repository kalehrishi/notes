<?php
namespace Notes\Model;

class UserTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     *@test
     *
     **/
    public function it_should_set_multiple_properties()
    {
        
        $userTagInput = array(
            'id' => 1,
            'userId' => 2,
            'Tag' => 'People',
            'isDeleted' => 1
        );
        $userTag      = new UserTag();
        $userTag->setId($userTagInput['id']);
        $userTag->setUserId($userTagInput['userId']);
        $userTag->setTag($userTagInput['Tag']);
        $userTag->setIsDeleted($userTagInput['isDeleted']);
        
        $this->assertEquals(1, $userTag->getId());
        $this->assertEquals(2, $userTag->getUserId());
        $this->assertEquals('People', $userTag->getTag());
        $this->assertEquals(1, $userTag->getIsDeleted());
        
    }
    /**
     *@test
     *
     **/
    public function it_should_set_single_property()
    {
        $userTagInput = array(
            'Tag' => 'People'
        );
        $userTag      = new UserTag();
        $userTag->setTag($userTagInput['Tag']);
        
        $this->assertEquals("People", $userTag->getTag());
    }
    /**
     *@test
     *
     **/
    public function it_should_convert_object_into_array()
    {
        $userTagInput = array(
            'id' => 1,
            'userId' => 2,
            'tag' => 'People',
            'isDeleted' => 1
        );
        
        $userTagModel = new UserTag();
        $userTagModel->setId($userTagInput['id']);
        $userTagModel->setUserId($userTagInput['userId']);
        $userTagModel->setTag($userTagInput['tag']);
        $userTagModel->setIsDeleted($userTagInput['isDeleted']);
        
        $this->assertEquals($userTagInput, $userTagModel->toArray());
    }
}
