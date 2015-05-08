<?php

use Notes\Helper\WebTestClient as WebTestClient;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    *
    **/
    public function register_get()
    {
        $client=new WebTestClient();
                
        $client->get('/register');

        $this->assertEquals(200, $client->response->status());        
    }

    /**
    * @test
    *
    **/
    public function user_register()
    {
        $client=new WebTestClient();
        
        $parameters = array(
                    'firstName' => 'William',
                    'lastName' => "Edwards",
                    'email' => "William@Edwards.com",
                    'password' => "AFd@756htrfj");
        
        $client->post('/register' ,$parameters);
        
        $this->assertEquals(302, $client->response->status());
        $this->assertEquals('/login', $client->response->getIterator()["Location"]);
        
    }
}
