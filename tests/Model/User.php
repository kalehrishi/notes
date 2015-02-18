<?php
namespace Notes\Model;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateObject()
    {
        $user = new User();
        $this->assertInstanceOf('Notes\Model\User', $user);
    }
}
