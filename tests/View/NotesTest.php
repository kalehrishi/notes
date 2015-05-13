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
		$response = array (
			    '0' => array ( 
                    'id' => 3,
                    'userId' => 1 ,
                    'title' => 'Html',
                    'body' => 'jljlfjldsjfldjl',
                    'createdOn' => '2015-02-16 10:19:12',
                    'lastUpdatedOn' => ' ',
                    'isDeleted' => 0 ,
                    'noteTags' => ' ' ),
                '1' => array (
                    'id' => 2,
                    'userId' => 1,
                    'title' => 'PHP5',
                    'body' => 'Server scripting language.',
                    'createdOn' => '2015-02-16 10:19:12',
                    'lastUpdatedOn' => ' ', 
                    'isDeleted' => 0 ,
                    'noteTags' => ' ' ));
        
		require "app/View/Notes.php";

		$this->assertEquals("PHP5" , $response['1']['title']);
		$this->assertEquals("Html" , $response['0']['title']);
	}
	   
	public function tearDown()
	{
		ob_get_clean();
	}
}
