<?php
namespace Notes\Factory;

use Notes\Factory\User as UserFactory;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_create_user_when_id_not_null()
    {
        
        $input       = array(
            'id'       =>1
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $this->assertEquals(1, $userModel->getId());
       
        
    }
    
     
   
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_read_user_when_email_password_is_not_null()
    {
        
        $input     = array(
           'email' => 'anusha@gmail.com',
           'password' => "anushA@h21"
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
      
        $this->assertEquals('anushA@h21', $userModel->getPassword());
      
        
    }
 
    /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_update_user_when_all_fields_are_not_null()
    {
        
        $input     = array(
            'id' => 1,
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhZ@223',
            'createdOn' => '2014-10-29 20:59:59'
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('julie', $userModel->getFirstName());
        $this->assertEquals('shah', $userModel->getLastName());
        $this->assertEquals('priya@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhZ@223', $userModel->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $userModel->getCreatedOn());
      
        
    }
     /**
     * @test
     *
     */
    public function it_should_set_usermodel_for_update_user_when_all_fields_are_null()
    {
        
        $input     = array(
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhZ@223',
            'createdOn' => '2014-10-29 20:59:59'
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        
        
        $this->assertEquals('julie', $userModel->getFirstName());
        $this->assertEquals('shah', $userModel->getLastName());
        $this->assertEquals('priya@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhZ@223', $userModel->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $userModel->getCreatedOn());
      
        
    }
}
