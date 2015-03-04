<?php

namespace Notes\Model;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    *
    **/
    public function it_should_set_and_get_id()
    {
        $input   = array(
            'id' => 1
        );
        $session = new Session();

        $session->setId($input['id']);

        $this->assertEquals(1, $session->getId());
    }
    
    /**
    * @test
    *
    **/
    public function it_should_set_and_get_userId()
    {
        $input   = array(
            'userId' => 2
        );
        $session = new Session();

        $session->setUserId($input['userId']);

        $this->assertEquals(2, $session->getUserId());
    }

    /**
    * @test
    *
    **/
    public function it_should_set_and_get_authToken()
    {
        $input   = array(
            'authToken' => 'abc'
        );
        $session = new Session();

        $session->setAuthToken($input['authToken']);

        $this->assertEquals('abc', $session->getAuthToken());
    }
    
    /**
    * @test
    *
    **/
    public function it_should_set_and_get_createdOn()
    {
        $input   = array(
            'createdOn' => '2015-02-16 08:56:44'
        );
        $session = new Session();

        $session->setCreatedOn($input['createdOn']);

        $this->assertEquals('2015-02-16 08:56:44', $session->getCreatedOn());
    }
    
    /**
    * @test
    *
    **/
    public function it_should_set_and_get_expirededOn()
    {
        $input   = array(
            'expiredOn' => '2015-02-16 08:56:44'
        );
        $session = new Session();

        $session->setExpiredOn($input['expiredOn']);

        $this->assertEquals('2015-02-16 08:56:44', $session->getExpiredOn());
    }

    /**
    * @test
    *
    **/
    public function it_should_set_and_get_isExpired()
    {
        $input   = array(
            'isExpired' => '0'
        );
        $session = new Session();

        $session->setIsExpired($input['isExpired']);

        $this->assertEquals('0', $session->getIsExpired());
    }

    /**
    * @test
    *
    **/
    public function it_should_generate_authToken()
    {
            $password = 'abc';
            $randomNumber = 121;

        $session = new Session();
    
        $session->createAuthToken($password,$randomNumber);
        
        $actual = $session->getAuthToken();
        $this->assertEquals('c3f3c4ffb150f5c87cec3164662e03dd',$actual);
    }
}
