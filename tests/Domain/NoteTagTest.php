<?php

namespace Notes\Domain;

use Notes\Mapper\NoteTag as NoteTagMapper;

use Notes\Model\NoteTag as NoteTagModel;
use Notes\Model\UserTag as UserTagModel;

use Notes\Model\Note as NoteModel;

use Notes\Domain\UserTag as UserTagDomain;
use Notes\Domain\NoteTag as NoteTagDomain;

use Notes\Config\Config as Configuration;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class NoteTagTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $connection;
    
    public function getConnection()
    {
        $config     = new Configuration("config.json");
        $configData = $config->get();
        $dbHost     = $configData['dbHost'];
        $dbName     = $configData['dbName'];
        $hostString = "mysql:host=$dbHost;dbname=$dbName";
        
        try {
            $this->connection = new \PDO($hostString, $configData['dbUser'], $configData['dbPassword']);
            $this->connection->exec("set foreign_key_checks=0");
            return $this->createDefaultDBConnection($this->connection, $dbName);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/noteTagDomain_seed.xml');
    }
    
    public function testCanCreateNoteTag()
    {
        $input = array(
            'noteId' => 3,
            'userId' => 1,
            'userTag' => 'WordPress',
            'isDeleted' => 0
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setTag($input['userTag']);
        $userTagModel->setUserId($input['userId']);
        
        $userTagDomain = new UserTagDomain();
        $userTagModel = $userTagDomain->create($userTagModel);

        $noteTagModel = new NoteTagModel();
        $noteTagModel->setUserTag($userTagModel);
        $noteTagModel->setUserTagId($userTagModel->getId());
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagDomain = new NoteTagDomain();
        $noteTagModel  = $noteTagDomain->create($noteTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTagDomain_after_create.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        $this->assertEquals(4, $noteTagModel->getId());
        $this->assertEquals(3, $noteTagModel->getNoteId());
        $this->assertEquals(4, $noteTagModel->getUserTagId());
        $this->assertEquals(0, $noteTagModel->getIsDeleted());
        
        $this->assertEquals(4, $noteTagModel->getUserTag()->getId());
        $this->assertEquals(1, $noteTagModel->getUserTag()->getUserId());
        $this->assertEquals('WordPress', $noteTagModel->getUserTag()->getTag());

        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
     * @expectedException         PDOException
    */
    public function testThrowsExceptionWhenUserTagIdIsNull()
    {
        $input = array(
            'noteId' => 1,
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->create($noteTagModel);
    }
    public function testCanReadNoteTagByNoteId()
    {
        $input = array(
            'noteId' => 1
        );
        
        $noteModel = new NoteModel();
        $noteModel->setId($input['noteId']);
        
        
        $noteTagDomain = new NoteTag();
        $noteTagCollection  = $noteTagDomain->readAllTagByNoteId($noteModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTagDomain_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(2, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(2, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getIsDeleted());

            $this->assertEquals(2, $noteTagCollection->getRow(0)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getUserId());
            $this->assertEquals('Tax', $noteTagCollection->getRow(0)->getUserTag()->getTag());

            $noteTagCollection->next();
        }
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    public function testCanReadByNoteTagId()
    {
        $input = array(
            'id' => 3
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->readByNoteTagId($noteTagModel);
        
        $this->assertEquals(3, $noteTagModel->getId());
        $this->assertEquals(2, $noteTagModel->getNoteId());
        $this->assertEquals(3, $noteTagModel->getUserTagId());
            $this->assertEquals(0, $noteTagModel->getIsDeleted());

            $this->assertEquals(3, $noteTagModel->getUserTag()->getId());
            $this->assertEquals(2, $noteTagModel->getUserTag()->getUserId());
            $this->assertEquals('People', $noteTagModel->getUserTag()->getTag());

    }
    /**
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function testThrowsExceptionWhenNoteTagIdDoesNotExist()
    {
        $input = array(
            'id' => 54
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->readByNoteTagId($noteTagModel);
    }
    public function testCanDeleteNoteTag()
    {
        $input = array(
            'id' => 3,
            'noteId' => 2,
            'userTagId' => 3,
            'isDeleted' => 0
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->update($noteTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTagDomain_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        $this->assertEquals(3, $noteTagModel->getId());
        $this->assertEquals(2, $noteTagModel->getNoteId());
        $this->assertEquals(3, $noteTagModel->getUserTagId());
        $this->assertEquals(1, $noteTagModel->getIsDeleted());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenNoteTagIdIsNull()
    {
        $input = array(
            'noteId' => 2,
            'userTagId' => 3,
            'isDeleted' => 0
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->update($noteTagModel);
    }
}
