<?php
namespace Notes\Service;

use Notes\Service\User as UserService;

use Notes\Model\User as UserModel;

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
            
    
        
        $userModel = new UserModel();
      
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        $userModel->setCreatedOn($userInput['createdOn']);


        $userService  =new UserService();
        $userModel    = $userService->createUser($userModel);

        $this->assertEquals('julie', $userModel->getFirstName());
        $this->assertEquals('shah', $userModel->getLastName());
        $this->assertEquals('priya@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhZ@223', $userModel->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $userModel->getCreatedOn());
     
    }
}
