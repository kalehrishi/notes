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

    /**
    * @test
    *
    **/
    public function registerpage_should_be_loaded()
    {
        $client=new ClientRequest();
                
        $client->get('/register');

        $this->assertEquals(200, $client->response->status());        
    }

    /**
    * @test
    *
    **/
    public function loginpage_should_be_loaded_after_user_registration()
    {
        $client=new ClientRequest();
        
        $parameters = array(
                    'firstName' => 'William',
                    'lastName' => "Edwards",
                    'email' => "William@Edwards.com",
                    'password' => "AFd@756htrfj");
        
        $client->post('/register' ,$parameters);
        
        $this->assertEquals(302, $client->response->status());
        $this->assertEquals('/login', $client->response->getIterator()["Location"]);
        
    }

    /**
    * @test
    *
    **/
    public function user_registration_failed_and_should_stay_on_same_page()
    {
        $client=new ClientRequest();
        
        $parameters = array(
                    'firstName' => 'William',
                    'lastName' => "Edwards",
                    'password' => "AFd@756htrfj");
        
        $client->post('/register' ,$parameters);
        
        $this->assertEquals(200, $client->response->status());        
    }

    /**
    * @test
    *
    **/
    public function loginpage_should_be_loaded()
    {
        $client=new ClientRequest();
                
        $client->get('/login');
        
        $this->assertEquals(200, $client->response->status());        
    }
    
    /**
    *@test
    *
    **/
    public function loginpage_should_be_loaded_after_user_logged_in()
    {
        $client=new ClientRequest();
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
        $client=new ClientRequest();
        $parameters = array('email' => "Joy@Edwards.com",
                    'password' => "AFd756htrfj");

        $client->post('/login', $parameters);
        $this->assertEquals(200, $client->response->status());
    }
}
