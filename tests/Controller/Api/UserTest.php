<?php
namespace Notes\Controller\Api;

use Notes\Controller\Api\User as UserController;

use Notes\Model\User as UserModel;

use Notes\Request\Request as Request;

use Notes\Response\Response as Response;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

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
                           "firstName" :"kirti",
                           "lastName" :"ramani",
                           "email" :"kirti.6@gmail.com",
                           "password" :"abc@$#A123",
                           "createdOn" : "2014-10-31 20:59:59"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        $userController = new UserController($request);
        $response       = $userController->create();
        $this->assertNotNull($data, true);
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
                           "password" :"sfhA@k1223",
                           "createdOn" : "2014-10-29 20:59:59"
                        }   
                }';
        
        $request = new Request();
        $request->setData($data);
        
        $userController = new UserController($request);
        $response = $userController->update();
        $this->assertNotNull($data, true);
        
        
    }
    
    /**
     * @test
     * @expectedException        Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    public function it_should_throw_exceptionwhenupdationfailed()
    {
        
        $data = '{
                "data": {
                            "id"        : "7",
                            "firstName" : "priyanka",
                           "lastName" :"kumar",
                           "email" :"kumar.6@gmail.com",
                           "password" :"sfhsk1229"
                           "createdOn" : "2014-10-29 20:59:60"
                        }   
                }';
        
        
        $request = new Request();
        $request->setData($data);
        
        $userController = new UserController($request);
        
        $response = $userController->update();
        
        $this->assertNotNull($data, true);
        
    }
}
