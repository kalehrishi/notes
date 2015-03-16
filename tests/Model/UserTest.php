<?php
namespace Notes\Model;

use Notes\Model\User as UserModel;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetMultipleProperties()
    {
        
        $input     = array(
            'id' => 1,
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userModel = new UserModel();
        $userModel->setId($input['id']);
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
      
    }
    
    public function testCanSetSingleProperty()
    {
        
        $input     = array(
            'firstName' => 'anusha'
        );
        $userModel = new UserModel();
        $userModel->setId($input['firstName']);
        $this->assertEquals('anusha', $userModel->getId());
        
    }
}
