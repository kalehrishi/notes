<?php

namespace Notes\Model;

use Notes\Model\Session;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateObject()
    {
        $session = new Session();
        
        $this->assertInstanceOf('Notes\Model\Session', $session);
    }
}
