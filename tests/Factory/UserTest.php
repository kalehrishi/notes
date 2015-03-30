<?php
namespace Notes\Factory;

use Notes\Factory\User as UserFactory;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /*
     * @test
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should be Number
    */
    public function it_should_throw_exception_when_id_is_not_number()
    {
        
        $input       = array(
            'id' => ' '
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $this->assertEquals(1, $userModel->getId());
        
        
    }
    /*
     * @test
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should be Number
    */
    public function it_should_throw_exception_when_id_is_string()
    {
        
        $input       = array(
            'id' => 'test'
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
    }
    
    /*
     * @test
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
    */
    public function it_should_throw_exception_when_id_is_null()
    {
        
        $input       = array(
            'id' => null
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $this->assertEquals(1, $userModel->getId());
    }

    /**
     * @test
    */
    public function it_should_create_userModel_for_read()
    {
        
        $input       = array(
            'id' => 1
            
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $this->assertEquals(1, $userModel->getId());
    }
    
    /**
     * @test
     *
    */
    public function it_should_create_userModel_for_read_by_email_and_password()
    {
        $input       = array(
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
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
    */
    public function it_should_throw_exception_when_all_fields_are_null()
    {
        
        $input = array();
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        
    }
    /**
     * @test
     * @expectedException          InvalidArgumentException
     * @expectedExceptionMessage   Invalid Email
    */
    public function it_should_throw_exception_when_email_is_invalid()
    {
        
        $input = array(
            'email' => 'anushagmail.com',
            'password' => "anushA@h21"
        );
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
    }
    /**
     * @test
     * @expectedException          InvalidArgumentException
     * @expectedExceptionMessage   Input should not be null
    */
    public function it_should_throw_exception_when_email_is_empty()
    {
        
        $input = array(
            'password' => "anushA@h21"
        );
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        print_r($userModel);
    }
    
    /**
     * @test
     *
    */
    public function it_should_create_userModel_for_create_user()
    {
        
        $input       = array(
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
    
    /**
     * @test
     *
    */
    public function it_should_create_userModel_for_updating_user()
    {
        
        $input       = array(
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
}
