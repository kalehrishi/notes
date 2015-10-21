<?php
namespace Notes\View;

use Notes\Collection\NoteCollection as NoteCollection;

class NotesTest extends \PHPUnit_Framework_TestCase
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
    public function response_data_should_access_in_Notes_View()
    {
        $notes = array("notesCollection" => array(
                "0" => array(
                    "id" => 1,
                    "title" =>"Html"
                    )
                ));
        
        $contentTemplateName = 'notes';

        $output  = $this->view->renderContent($contentTemplateName, $notes);
        
        $dom    = new \DOMDocument();
        
        $dom->loadHTML($output);
        $element = $dom->getElementsByTagName('a');
        
        $this->assertEquals("Create", $element->item(0)->nodeValue);
        $this->assertEquals("Logout", $element->item(1)->nodeValue);

        $element = $dom->getElementsByTagName('span');
        $this->assertEquals("Html", $element->item(2)->nodeValue);
    }

    public function tearDown()
    {
        ob_end_clean();
    }
}
