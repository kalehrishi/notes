<?php
namespace Notes\Controller\Api;

use Notes\Controller\Api\Session as Session;
use Notes\Request\Request as Request;
//use Notes\Config\Config as Configuration;
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
                            "email" : "anusha@gmail.com",
                           "password" :"anushA@h21"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        $sessionController = new Session($request);
        
        $data = $sessionController->post();
        


    }
    
    /**
     * @test
     *
     **/
    public function it_should_delete_session_if_user_login()
    {
        $data    = '{
                "data": {
                            "authToken" : "abc",
                            "userId" :"1"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        $sessionController = new Session($request);
        
        $response = $sessionController->delete();
        
    }
}
