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
        $noteModel = new NoteModel();
        $noteModel->setId(1);
        
        $noteService = new NoteService();
        $response    = $noteService->get($noteModel);
        
        $fileName = "Note.php";
        $this->view->render($fileName, $response);
        
        $dom = new \DOMDocument();
        
        $htmlData = ob_get_clean();
        
        $dom->loadHTML($htmlData);
        $element = $dom->getElementsByTagName('div');
        
        $this->assertEquals("PHP", $element->item(0)->textContent);
        
        $this->assertEquals("Preprocessor Hypertext", $element->item(1)->textContent);
        
        $element = $dom->getElementsByTagName('span');

        $this->assertEquals("No Tags", $element->item(0)->textContent);
    }
}
