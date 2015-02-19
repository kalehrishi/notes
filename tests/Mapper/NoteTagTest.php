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
        $noteTagModel = new NoteTagModel($input);
        
        $noteTagMapper = new NoteTag();
        $result         = $noteTagMapper->read($noteTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTag_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('1', $result->id);
        $this->assertEquals('4', $result->noteId);
        $this->assertEquals('3', $result->userTagId);
    }
    /**
    * @expectedException              Exception
    * @expectedExceptionMessage       NoteTagId Does Not Present
    */
    public function testNotTagIdDoesNotExist()
    {
        $input        = array(
            'id' => 2
        );
        $noteTagModel = new NoteTagModel($input);
        
        $noteTagMapper = new NoteTag();
        $result        = $noteTagMapper->read($noteTagModel);
        
    }
    public function testCanInsertRecord()
    {
        $input        = array(
            'noteId' => 1,
            'userTagId' => 1
        );
        $noteTagModel = new NoteTagModel($input);
        
        $noteTagMapper = new NoteTag();
        $result         = $noteTagMapper->create($noteTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTags_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        $this->assertEquals(2, $result->id);
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
        $noteTagModel = new NoteTagModel($input);
        
        $noteTagMapper = new NoteTag();
        $result        = $noteTagMapper->create($noteTagModel);
    }
    
    /**
    * @expectedException              PDOException
    * @expectedExceptionMessage       Column 'noteId' cannot be null
    */
    public function testInsertFailedWhenParameterIsMismached()
    {
        $input        = array(
            'note' => 1,
            'userTagId' => 1
        );
        $noteTagModel = new NoteTagModel($input);
        
        $noteTagMapper = new NoteTag();
        $result        = $noteTagMapper->create($noteTagModel);
    }
}
