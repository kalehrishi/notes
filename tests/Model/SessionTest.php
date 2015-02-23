<?php

namespace Notes\Model;


class SessionTest extends \PHPUnit_Framework_TestCase
{
  public function testCanSetAndGetId()
    {
      $input = array('id'=>1
        );
       $session= new Session();
       $session->setId($input['id']);
       $this->assertEquals(1, $session->getId());
       
    }
    public function testCanSetAndGetUserId()
    { $input = array('userId'=>'2'
      );
       $session= new Session();
       $session->setUserId($input['userId']);
       $this->assertEquals('2', $session->getUserId());
    }

   public function testCanSetAndGetcreatedOn()
    { $input = array('createdOn'=>'2015-02-16 08:56:44'
      );
       $session= new Session();
       $session->setCreatedOn($input['createdOn']);
       $this->assertEquals('2015-02-16 08:56:44', $session->getCreatedOn());
    }

   public function testCanSetAndGetexpirededOn()
    { $input = array('expiredOn'=>'2015-02-16 08:56:44'
      );
       $session= new Session();
       $session->setExpiredOn($input['expiredOn']);
       $this->assertEquals('2015-02-16 08:56:44', $session->getExpiredOn());
    }
   public function testCanSetAndGetIsExpired()
    { $input = array('isExpired'=>'0'
      );
       $session= new Session();
       $session->setIsExpired($input['isExpired']);
       $this->assertEquals('0', $session->getIsExpired());
    }

}




