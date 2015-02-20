<?php

namespace Notes\Model;


class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateObject()
    { $params = array('id'=>1, 'userId'=>1,'createdOn' => '2015-02-16 08:56:44', 'expiredOnOn' => '2015-02-16 08:56:44', 'isExpired' => 0);
        $session = new Session($params);
      
        $this->assertInstanceOf('Notes\Model\Session', $session);
    }

}


