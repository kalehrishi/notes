<?php
namespace Notes\Model;

class UserTagTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCanSetAndAccessMultipleProperties()
    {
        
        $input   = array(
            'id' => 1,
            'userId' => 2,
            'Tag' => 'People',
            'isDeleted' => 1
        );
        $userTag = new UserTag();
        $userTag->setId($input['id']);
        $userTag->setUserId($input['userId']);
        $userTag->setTag($input['Tag']);
        $userTag->setIsDeleted($input['isDeleted']);
        
        $this->assertEquals(1, $userTag->getId());
        $this->assertEquals(2, $userTag->getUserId());
        $this->assertEquals('People', $userTag->getTag());
        $this->assertEquals(1, $userTag->getIsDeleted());
        
    }
    public function testCanSetAndAccessSingleProperty()
    {
        $input   = array(
            'Tag' => 'People'
        );
        $userTag = new UserTag();
        $userTag->setTag($input['Tag']);
        
        $this->assertEquals("People", $userTag->getTag());
    }
}
