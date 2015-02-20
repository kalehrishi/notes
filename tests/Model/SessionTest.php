<?php

namespace Notes\Model;


class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetAndGetUserId()
    { $session = new Session(array('id'=>1, 'userId'=>1,'createdOn' => '2015-02-16 08:56:44', 'expiredOn' => '2015-02-16 08:56:44', 'isExpired' => 0));
       $this->assertEquals('1', $session->userId);
    }
  public function testCanSetAndGetcreatedOn()
    { $session = new Session(array('id'=>1, 'userId'=>1,'createdOn' => '2015-02-16 08:56:44', 'expiredOn' => '2015-02-16 08:56:44', 'isExpired' => 0));
       $this->assertEquals('2015-02-16 08:56:44', $session->createdOn);
    }

    public function testCanSetAndGetExpiredOn()
    { $session = new Session(array('id'=>1, 'userId'=>1,'createdOn' => '2015-02-16 08:56:44', 'expiredOn' => '2015-02-16 08:56:44', 'isExpired' => 0));
       $this->assertEquals('2015-02-16 08:56:44', $session->expiredOn);
    }

  public function testCanSetAndGetIsExpired()
    { $session = new Session(array('id'=>1, 'userId'=>1,'createdOn' => '2015-02-16 08:56:44', 'expiredOn' => '2015-02-16 08:56:44', 'isExpired' => 0));
       $this->assertEquals('0', $session->isExpired);
    }

   
}



