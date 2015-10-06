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
    public function Home_page_loaded()
    {  
       $homeLayout = array('login' => 'Login');
        
        $contentTemplateName = 'login';

        $output  = $this->view->renderContent($contentTemplateName, $homeLayout);
        

        $dom    = new \DOMDocument();
        
        $dom->loadHTML($output);
        
        $element = $dom->getElementsByTagName('h1');
        
        $this->assertEquals("Login", $element->item(0)->nodeValue);
    }
    public function tearDown()
    {
        ob_end_clean();
    }
}
