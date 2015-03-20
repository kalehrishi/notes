<?php

namespace Notes\Controller;

use Notes\Controller\User as UserController;

class UserTest extends \PHPUnit_Framework_TestCase
{

     /**
     * @test
     *
     **/
    public function it_should_create_user()
    {
        $userInput = array(
            
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhZ@223',
            'createdOn' => '2014-10-29 20:59:59'
        );
        
        $userController = new UserController();
        
        $response = $userController->create($userInput);

        $this->assertEquals('julie', $response->getFirstName());
        $this->assertEquals('shah', $response->getLastName());
        $this->assertEquals('priya@gmail.com', $response->getEmail());
        $this->assertEquals('sfhZ@223', $response->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $response->getCreatedOn());


    }
}
