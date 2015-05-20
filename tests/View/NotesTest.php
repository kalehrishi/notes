<?php
namespace Notes\View;

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
        $response = array(
            '0' => array(
                'id' => 3,
                'userId' => 1,
                'title' => 'Html',
                'body' => 'jljlfjldsjfldjl',
                'createdOn' => '2015-02-16 10:19:12',
                'lastUpdatedOn' => ' ',
                'isDeleted' => 0,
                'noteTags' => ' '
            ),
            '1' => array(
                'id' => 2,
                'userId' => 1,
                'title' => 'PHP5',
                'body' => 'Server scripting language.',
                'createdOn' => '2015-02-16 10:19:12',
                'lastUpdatedOn' => ' ',
                'isDeleted' => 0,
                'noteTags' => ' '
            )
        );
        
        $fileName = "Notes.php";
        $this->view->render($fileName, $response);
        
        $dom    = new \DOMDocument();
        $output = ob_get_clean();
        
        $dom->loadHTML($output);
        
        $element = $dom->getElementsByTagName('a');
        
        $this->assertEquals("Logout", $element->item(0)->nodeValue);
        $this->assertEquals("Html", $element->item(1)->nodeValue);
        $this->assertEquals("PHP5", $element->item(2)->nodeValue);
        
        $element = $dom->getElementsByTagName('div');
        $this->assertEquals("Html", $element->item(0)->textContent);
        
        $element = $dom->getElementsByTagName('form');
        $this->assertEquals("notes/3", $element->item(0)->getAttribute('action'));
        $this->assertEquals("notes/2", $element->item(1)->getAttribute('action'));
    }
}
