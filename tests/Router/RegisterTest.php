<?php

use Notes\Helper\WebTestClient as WebTestClient;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
    
    public $application;
    public $client;
    
    // Run for each unit test to setup our slim app environment
    
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
    *@test
    *
    **/
    public function user_should_login_with_username_and_password()
    {  
        $param = array('email' => "William@Edwards.com",
                    'password' => "AFd@756htrfj");
        $this->client->post('/login', $param);
       //print_r($this->client->application->environment->offsetGet('PATH_INFO'));
       //print_r($this->client->request);

        $this->assertEquals(302, $this->client->response->status());
        $this->assertEquals('/notes', $this->client->response->getIterator()["Location"]);
    }
}
