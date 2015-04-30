<?php
require_once "bootstrap.php";
//include('simple_html_dom.php');


class RoutesTest extends LocalWebTestCase
{
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
        $this->assertEquals(302, $this->client->response->status());
        $this->assertEquals('/login', $this->client->response->getIterator()["Location"]);
    }
    /*public function user_should_login_with_username_and_password()
    {   
    	$parameters = array('email' => "gau@bhapkar.com",'password' => "Gauri@123");
        $this->client->post('/login', $parameters);
        $this->assertEquals(302, $this->client->response->status());
        $this->assertEquals('/notes', $this->client->response->getIterator()["Location"]);
    }*/
}
