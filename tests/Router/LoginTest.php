<?php

use Notes\Helper\WebTestClient as WebTestClient;

class LoginTest extends \PHPUnit_Framework_TestCase
{
    
    public $application;
    public $client;
       
    public function setUp()
    {
        $this->application    = $this->getSlimInstance();
        $this->client = new WebTestClient($this->application);
    }

    public function getSlimInstance()
    {
        $application = new \Slim\Slim(array(
          'version'        => '0.0.0',
          'debug'          => false,
          'mode'           => 'testing',
        ));
     
        require "app/Router/Routes.php";
        return $application;
    }
    /**
    * @test
    *
    **/
    public function user_register()
    {
        $parameters = array(
                    'firstName' => 'William',
                    'lastName' => "Edwards",
                    'email' => "William@Edwards.com",
                    'password' => "AFd@756htrfj");
        
        $this->client->post('/register' ,$parameters);
        //print_r($this->client->application->environment->offsetGet('PATH_INFO'));
        //print_r($this->client->request);
        $this->assertEquals(302, $this->client->response->status());
        $this->assertEquals('/login', $this->client->response->getIterator()["Location"]);
    }
      
    public function tearDown()
    {

    }  
}
