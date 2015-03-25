<?php
namespace Notes\Model;

use Notes\Model\User as UserModel;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
    *@test
    *
    **/
    public function it_should_set_multiple_properties()
    {
        
        $userInput     = array(
            'id' => 1,
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userModel = new UserModel();
        $userModel->setId($userInput['id']);
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        $userModel->setCreatedOn($userInput['createdOn']);

        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
      
    }
    /**
    *@test
    *
    **/
    
    public function it_should_set_single_property()
    {
        
        $userInput     = array(
            'firstName' => 'anusha'
        );
        $userModel = new UserModel();
        $userModel->setId($userInput['firstName']);
        $this->assertEquals('anusha', $userModel->getId());
        
    }
    /**
    *@test
    *
    **/
    public function it_should_convert_object_into_array()
    {
        $userInput=array(
            'id' => 1,
            'firstName' => 'Joy',
            'lastName' => 'Mock',
            'email' => 'joy@mok.com',
            'password' => 'Joy#@Mo124',
            'createdOn' => '2014-2-4 12:41:36');
        
        $userModel=new UserModel();
        $userModel->setId($userInput['id']);
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        $userModel->setCreatedOn($userInput['createdOn']);
        
        
        $this->assertEquals($userInput,$userModel->toArray());
    }
}
