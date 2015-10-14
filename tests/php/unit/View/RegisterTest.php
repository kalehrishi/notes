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
    public function Register_page_loaded()
    {
        $registerLayout = array(
            "formTitle"=> "User Registration Form"
        );
        
        $contentTemplateName = 'register';

        $output  = $this->view->renderContent($contentTemplateName, $registerLayout);
        
        $dom    = new \DOMDocument();
        
        $dom->loadHTML($output);

        $element = $dom->getElementsByTagName('legend');
        $this->assertEquals("User Registration Form:", $element->item(0)->nodeValue);
    }
    public function tearDown()
    {
        ob_end_clean();
    }
}
