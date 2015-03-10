<?php
namespace Notes\Factory;

use Notes\Factory\User as UserFactory;

class UserTest extends \PHPUnit_Framework_TestCase
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
}
