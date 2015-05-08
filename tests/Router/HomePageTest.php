<?php

use Notes\Helper\WebTestClient as WebTestClient;

class HomePageTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    *
    **/
    public function root()
    {
        $client=new WebTestClient();
        
        $client->get('/');
        $this->assertEquals(200, $client->response->status());
    }
    
    /**
    * @test
    *
    **/
    public function root_home()
    {
        $client=new WebTestClient();
        $parameters = array('home');
        
        $client->get('/' ,$parameters);
        $this->assertEquals(200, $client->response->status());        
    }
}
