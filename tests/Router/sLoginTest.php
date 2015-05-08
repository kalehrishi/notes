<?php

use Notes\Helper\WebTestClient as WebTestClient;

class sLoginTest extends \PHPUnit_Framework_TestCase
{
   /**
    * @test
    *
    **/
    public function login_get()
    {
        $client=new WebTestClient();
                
        $client->get('/login');
        
        $this->assertEquals(200, $client->response->status());        
    }
    
    /**
    *@test
    *
    **/
    public function user_should_login_and_redirect_to_notes_page()
    {
        $client=new WebTestClient();
        $parameters = array('email' => "William@Edwards.com",
                    'password' => "AFd@756htrfj");
        $client->post('/login', $parameters);

        $this->assertEquals(302, $client->response->status());
        $this->assertEquals('/notes', $client->response->getIterator()["Location"]);
    }

    /**
    * @test
    *
    **/
    public function user_login_failed_and_should_stay_on_same_page()
    {
        $client=new WebTestClient();
        $parameters = array('email' => "William@Edwards.com",
                    'password' => "AFd756htrfj");

        $client->post('/login', $parameters);
        $this->assertEquals(200, $client->response->status());
    }
}
