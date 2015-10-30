<?php
namespace Notes\View;

use Notes\View\View as View;

class HomeTest extends \PHPUnit_Framework_TestCase
{
    protected $view;
    public function setUp()
    {
        ob_start();
        $this->view    = new View();
    }
    /**
     *@test
     *
     **/
    public function Home_page_loaded()
    {
        $homeLayout = array(
            "h1"=> "Wel-come to Sticky-notes",
            "register"=> "New User:Register",
            "login"=> "Login"
        );
        
        $contentTemplateName = 'home';

        $output  = $this->view->renderContent($contentTemplateName, $homeLayout);
        

        $dom    = new \DOMDocument();
        
        $dom->loadHTML($output);
        
        $element = $dom->getElementsByTagName('h1');
        $this->assertEquals("Wel-come to Sticky-notes", $element->item(0)->nodeValue);
        
        $element = $dom->getElementsByTagName('span');
        $this->assertEquals("New User:Register", $element->item(0)->nodeValue);
        $this->assertEquals("Login", $element->item(1)->nodeValue);
    }
    public function tearDown()
    {
        ob_end_clean();
    }
}
