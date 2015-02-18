<?php
namespace Notes\Model;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateObject()
    {
    	$params = array('id'=>1, 'userId'=>1, 'title'=>'PHP', 'body'=>'Preprocessor Hypertext','createdOn' => '2015-02-16 08:56:44', 'lastUpdateOn' => '2015-02-16 08:56:44', 'isDeleted' => 0);
        $note = new Note($params);
        $this->assertInstanceOf('Notes\Model\Note', $note);
    }
}
