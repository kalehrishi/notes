<?php

use Notes\Helper\WebTestClient as WebTestClient;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    
    /**
    *@test
    *
    **/
    public function user_should_login_with_username_and_password()
    {
        $client=new WebTestClient();
        $param = array('email' => "anu@hm.com",
                    'password' => "Anusha#123");
        $client->post('/login', $param);
       //print_r($this->client->application->environment->offsetGet('PATH_INFO'));
       //print_r($client->response);
       //print_r($client->request->cookies);


        $this->assertEquals(302, $client->response->status());
        $this->assertEquals('/notes', $client->response->getIterator()["Location"]);
    }
    /**
    * @test
    *
    **/
    /*public function Notes()
    {
        $client=new WebTestClient();
      
        
        $client->get('/logout');
        print_r($this->client->application->environment->offsetGet('PATH_INFO'));
        print_r($this->client->request);
        $this->assertEquals(302, $client->response->status());
        $this->assertEquals('/login', $client->response->getIterator()["Location"]);
    }*/
}
