<?php
namespace Notes\Helper;

class HomePageTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    *
    **/
    public function homepage_should_be_loaded()
    {
        $client=new ClientRequest();
        
        $client->get('/');
        $this->assertEquals(200, $client->response->status());
    }
    
    /**
    * @test
    *
    **/
    public function homepage_should_be_loaded_with_url_parameter_home()
    {
        $client=new ClientRequest();
        $parameters = array('home');
        
        $client->get('/' ,$parameters);
        $this->assertEquals(200, $client->response->status());        
    }
}
