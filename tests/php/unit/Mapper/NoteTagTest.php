<?php

namespace Notes\Mapper;

use Notes\Config\Config as Configuration;

use Notes\Model\NoteTag as NoteTagModel;

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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/noteTags_seed.xml');
    }
    
    
    public function testCanReadRecordByNoteId()
    {
        $input        = array(
            'noteid' => 4
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteid']);
        
        
        $noteTagMapper = new NoteTag();
        $noteTagCollection  = $noteTagMapper->findNoteTagsByNoteId($noteTagModel);
       
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTag_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(4, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(3, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getIsDeleted());
            $noteTagCollection->next();
        }
    }
    /**
    * @expectedException         Notes\Exception\ModelNotFoundException
    * @expectedExceptionMessage  Can Not Found Given Model In Database
    */
    public function testNoteTagIdDoesNotExist()
    {
        $input        = array(
            'id' => 122
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->read($noteTagModel);
        
    }
    public function testCanInsertRecord()
    {
        $input        = array(
            'noteId' => 1,
            'userTagId' => 1
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->create($noteTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTags_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        $this->assertEquals(2, $noteTagModel->getId());
        $this->assertEquals(1, $noteTagModel->getNoteId());
        $this->assertEquals(1, $noteTagModel->getUserTagId());
        $this->assertEquals(0, $noteTagModel->getIsDeleted());

        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    
    public function testCanDeleteRecord()
    {
        $input        = array(
            'id'=>1,
            'noteId'=>4,
            'userTagId' =>3,
            'isDeleted'=>1
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->update($noteTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTags_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        $this->assertEquals(1, $noteTagModel->getId());
        $this->assertEquals(4, $noteTagModel->getNoteId());
        $this->assertEquals(3, $noteTagModel->getUserTagId());
        $this->assertEquals(1, $noteTagModel->getIsDeleted());
    
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
    * @expectedException         Notes\Exception\ModelNotFoundException
    * @expectedExceptionMessage  Can Not Found Given Model In Database
    */
    public function testDeletionFailed()
    {
        $input        = array(
            'id' => 2,
            'noteId'=>4,
            'userTagId' =>3,
            'isDeleted'=>1
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->update($noteTagModel);
    }
}
