<?php
namespace Notes\Exception;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class ExceptionTest extends \PHPUnit_Framework_Testcase
{
    
    /**
     * @expectedException           Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage    Can Not Found Given Model In Database
     */
    public function testMessageThrowSucessfully()
    {
        $noteModel              = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $modelNotFoundException = new ModelNotFoundException();
        $modelNotFoundException->setModel($noteModel);
        throw $modelNotFoundException;
    }
    
    
    public function testCheckGivenModelDataIsEqual()
    {
        $noteModel              = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $modelNotFoundException = new ModelNotFoundException();
        $modelNotFoundException->setModel($noteModel);
        $returnModelData = $modelNotFoundException->getModel();
        $this->assertEquals($noteModel, $returnModelData);
    }
}
