<?php
namespace Notes\Model;

use Notes\Model\User as UserModel;

class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     *@test
     *
     **/
    public function it_should_create_instance()
    {
        $this->assertInstanceOf('Notes\Model\Model', new Model());
    }
}
