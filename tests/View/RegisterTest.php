<?php
namespace Notes\View;

class RegisterTest extends \PHPUnit_Framework_TestCase
{
	protected $view;
	public function setUp()
 	{
 	   ob_start();
       $this->view = new View();
       
	}    
    /**
	*@test
	*
	**/
	
	public function response_data_should_access_in_register_View()
	{
		$response = '{"status":"200",
		            "message":"OK",
		            "version":"1.0.0",
		            "data":"Input should be string",
		            "debugData":null }';
		require "app/View/Register.php";

		$this->assertEquals("Input should be string" , $data['data']);
		$this->assertEquals("200" , $data['status']);
	}
	public function tearDown()
	{
		ob_get_clean();
	}

}
	