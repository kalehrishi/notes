<?php

namespace Notes\Mapper;

use Notes\Config\Config as Configuration;

use Notes\Model\NoteTag as NoteTagModel;

class NoteTagTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $connection;
    
    public function getConnection()
    {
        $config     = new Configuration("app/Config/config.json");
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
    
    
    public function testCanReadRecordById()
    {
        $input        = array(
            'id' => 1
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->read($noteTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTag_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(1, $noteTagModel->getId());
        $this->assertEquals(4, $noteTagModel->getNoteId());
        $this->assertEquals(3, $noteTagModel->getuserTagId());
        $this->assertEquals(0, $noteTagModel->getIsDeleted());
    }
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       NoteTagId Does Not Present
     */
    public function testNoteTagIdDoesNotExist()
    {
        $input        = array(
            'id' => 2
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
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       Column 'noteId' cannot be null
     */
    public function testInsertFailedWhenParameterMissing()
    {
        $input        = array(
            'userTagId' => 1
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setUserTagId($input['userTagId']);
        
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->create($noteTagModel);
    }

    public function testCanDeleteRecord()
    {
        $input        = array(
            'id' => 1,
            'noteId'=>4,
            'userTagId' =>3,
            'isDeleted'=>0
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->delete($noteTagModel);
        
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
     * @expectedException              Exception
     * @expectedExceptionMessage       NoteTagId Does Not Present
     */
    public function testDeletionFailed()
    {
        $input        = array(
            'id' => 2,
            'noteId'=>4,
            'userTagId' =>3,
            'isDeleted'=>0
        );
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagMapper = new NoteTag();
        $noteTagModel  = $noteTagMapper->delete($noteTagModel);
    }
}
