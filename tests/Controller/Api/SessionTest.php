<?php

namespace Notes\Controller\Api;

use Notes\Controller\Api\Session as Session;
use Notes\Request\Request as Request;
use Notes\Config\Config as Configuration;
use Notes\Response\Response as Response;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     **/
    public function it_should_create_session_with_valid_email_password()
    {
        $data    = '{
                   "data": {
                            "email" : "pushpa@marade.com",
                           "password" :"Pushpa@123"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        $sessionController = new Session($request);
        
        $response = $sessionController->post();
        
        $this->assertNotNull($response);
    }
    
    /**
     * @test
     *
     **/
    public function it_should_delete_session_if_user_is_already_login()
    {
        $data    = '{
                "data": {
                            "authToken" : "abc",
                            "userId" :"2"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        $sessionController = new Session($request);
        
        $response = $sessionController->delete();
        $this->assertNotNull($response);
    }
    
    /**
     * @test
     */
    public function it_should_throw_exception_with_invalid_email_password()
    {
        
        $data    = '{
                "data": {
                            "email" : "abcd@gmail.com",
                           "password" :"pA@#$123"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        $sessionController = new Session($request);
        $response          = $sessionController->post();
        $this->assertNotNull($response);
    }
    
    /**
     * @test
     */
    public function it_should_throw_exception_with_invalid_authToken_userId()
    {
        $data    = '{
                "data": {
                            "authToken" : "xyz",
                           "userId" :"15"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        $sessionController = new Session($request);
        
        $response = $sessionController->delete();
        $this->assertNotNull($response);
        
    }
    
    /**
     * @test
     */
    public function it_should_throw_exception_for_logout_if_user_is_not_login()
    {
        $data    = '{
                "data": {
                            "email" : "gauri@bhapkar.com",
                           "password" :"Gauri@123"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        $sessionController = new Session($request);
        $response          = $sessionController->post();
        $this->assertNotNull($response);
    }
}
