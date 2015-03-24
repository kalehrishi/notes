<?php

namespace Notes\Controller;

use Notes\Controller\User as UserController;

use Notes\Model\User as UserModel;

use Notes\Request\Request as Request;

class UserTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @test
     *
     **/
    public function it_should_create_user()
    {
        $data    = '{
                "data": {
                            "firstName" : "kirti",
                           "lastName" :"ramani",
                           "email" :"kirti.6@gmail.com",
                           "password" :"abc@$#A123",
                           "createdOn" : "2014-10-31 20:59:59"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        
        
        $userController = new UserController($request);
        
        $response = $userController->create();
        
        $this->assertEquals('kirti', $response->getFirstName());
        $this->assertEquals('ramani', $response->getLastName());
        $this->assertEquals('kirti.6@gmail.com', $response->getEmail());
        $this->assertEquals('abc@$#A123', $response->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $response->getCreatedOn());
        
    }
    
    
    
    /**
     * @test
     *
     **/
    public function it_should_update_user()
    {
        $data = '{
                "data": {
                            "id" : "1",
                            "firstName" : "julie",
                           "lastName" :"shah",
                           "email" :"priya@gmail.com",
                           "password" :"sfhsk1223",
                           "createdOn" : "2014-10-29 20:59:59"
                        }   
                }';
        
        $request = new Request();
        $request->setData($data);
        
        
        $userController = new UserController($request);
        
        $response = $userController->update();
        
        $this->assertEquals(1, $response->getId());
        $this->assertEquals('julie', $response->getFirstName());
        $this->assertEquals('shah', $response->getLastName());
        $this->assertEquals('priya@gmail.com', $response->getEmail());
        $this->assertEquals('sfhsk1223', $response->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $response->getCreatedOn());
        
        
    }
    /**
     * @test
     * @expectedException Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    public function it_should_throw_exceptionwhenupdationfailed()
    {
        
        $data = '{
                "data": {
                            "id"        : "7",
                            "firstName" : "julia",
                           "lastName" :"shaha",
                           "email" :"priaya@gmail.com",
                           "password" :"ssfhsk1223",
                           "createdOn" : "21014-10-29 20:59:59"
                        }   
                }';
        
        $request = new Request();
        $request->setData($data);
        
        
        $userController = new UserController($request);
        
        $response = $userController->update();
    }
}
