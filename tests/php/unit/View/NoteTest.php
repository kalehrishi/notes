<?php
namespace Notes\View;

use Notes\Service\Note as NoteService;
use Notes\Model\Note as NoteModel;

class NoteTest extends \PHPUnit_Framework_TestCase
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
    public function response_data_should_access_in_Note_View()
    {
        $note = array(
                "title" =>"PHP",
                "body" => "Preprocessor Hypertext"
                    );     
        $contentTemplateName = 'note';

        $output  = $this->view->renderContent($contentTemplateName, $note);
        
        $dom    = new \DOMDocument();
        
        $dom->loadHTML($output);
        
        $element = $dom->getElementsByTagName('span');
        
        $this->assertEquals("PHP", $element->item(1)->nodeValue);
        
        $this->assertEquals("Preprocessor Hypertext", $element->item(2)->nodeValue);
    }

    public function tearDown()
    {
        ob_end_clean();
    }
}
