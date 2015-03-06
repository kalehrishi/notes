<?php
namespace Notes\Factory;

use Notes\Model\User as UserModel;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_create_user()
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
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_readUser_by_user_id()
    {
        $input       = array(
            'id' => 1
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->read($input);
        $this->assertEquals(1, $userModel->getId());
        
    }
    
    
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_readUser_by_username_and_email()
    {
        $input       = array(
            
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223'
            
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->readByUsernameandPassword($input);
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        
    }
    
    
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_updateUser()
    {
        $input       = array(
            'id' => 1,
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-29 20:59:59'
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->update($input);
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('julie', $userModel->getFirstName());
        $this->assertEquals('shah', $userModel->getLastName());
        $this->assertEquals('priya@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $userModel->getCreatedOn());
        
    }
}
