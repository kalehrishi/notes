<?php

namespace Notes\Model;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function test_can_set_and_get_id()
    {
        $input   = array(
            'id' => 1
        );
        $session = new Session();

        $session->setId($input['id']);

        $this->assertEquals(1, $session->getId());
    }
    
    public function test_it_should_set_and_get_userId()
    {
        $input   = array(
            'userId' => 2
        );
        $session = new Session();

        $session->setUserId($input['userId']);

        $this->assertEquals(2, $session->getUserId());
    }

    public function test_it_should_set_and_get_authToken()
    {
        $input   = array(
            'authToken' => 'abc'
        );
        $session = new Session();

        $session->setAuthToken($input['authToken']);

        $this->assertEquals('abc', $session->getAuthToken());
    }
    
    public function test_it_should_set_and_get_createdOn()
    {
        $input   = array(
            'createdOn' => '2015-02-16 08:56:44'
        );
        $session = new Session();

        $session->setCreatedOn($input['createdOn']);

        $this->assertEquals('2015-02-16 08:56:44', $session->getCreatedOn());
    }
    
    public function test_it_should_set_and_get_expirededOn()
    {
        $input   = array(
            'expiredOn' => '2015-02-16 08:56:44'
        );
        $session = new Session();

        $session->setExpiredOn($input['expiredOn']);

        $this->assertEquals('2015-02-16 08:56:44', $session->getExpiredOn());
    }
    
    public function test_it_should_set_and_get_isExpired()
    {
        $input   = array(
            'isExpired' => '0'
        );
        $session = new Session();

        $session->setIsExpired($input['isExpired']);

        $this->assertEquals('0', $session->getIsExpired());
    }
    public function test_it_should_generate_authToken()
    {
            $password = 'abc';
            $randomNumber = 121;

        $session = new Session();

        $actual=$session->createAuthToken($password,$randomNumber);
        
        $this->assertEquals('c3f3c4ffb150f5c87cec3164662e03dd',$actual);
    }
}
