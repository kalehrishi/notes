<?php
namespace Notes\Model;

use Notes\Model\User as UserModel;

use Notes\Factory\UserFactory as UserFactory;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetMultipleProperties()
    {
        
        $input       = array(
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        
    }
}
