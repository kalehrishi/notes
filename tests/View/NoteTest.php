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
        $response = $noteService->get($noteModel);
        
		require "app/View/Note.php";

		$this->assertEquals("1" , $response->getId());
		$this->assertEquals("PHP" , $response->getTitle());
	}
	   
	public function tearDown()
	{
		ob_get_clean();
	}
}
