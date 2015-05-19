<?php
namespace Notes\View;

class LoginTest extends \PHPUnit_Framework_TestCase
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
	public function response_data_should_access_in_login_View()
	{
		$response = '{"status":"200",
		            "message":"OK",
		            "version":"1.0.0",
		            "data":"Invalid Email",
		            "debugData":null }';
		$fileName= "Login.php";

		$this->view->render($fileName, $response);
        
        $output=ob_get_clean();

  		$this->assertContains("Invalid Email" , $output);
    }
}
