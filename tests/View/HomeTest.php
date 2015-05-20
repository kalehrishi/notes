<?php
namespace Notes\View;

class HomeTest extends \PHPUnit_Framework_TestCase
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
        
        require "app/View/Home.php";
        
        $dom    = new \DOMDocument();
        $output = ob_get_contents();
        
        $dom->loadHTML($output);
        
        $element = $dom->getElementsByTagName('a');
        
        $this->assertEquals("Register", $element->item(0)->getAttribute('target'));
        $this->assertEquals("Login", $element->item(1)->getAttribute('target'));
    }
    public function tearDown()
    {
        ob_end_clean();
    }
}
