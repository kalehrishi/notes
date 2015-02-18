<?php

namespace Notes\Mapper;

use Notes\Config\Config as Configuration;


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
        return $this->createXMLDataSet(dirname(__FILE__).'/_files/noteTags_seed.xml');
    }


    public function testCanReadRecordById()
     {
        $model=['id'=>1];
        $notetag=new NoteTag();
        $result=$notetag->read($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/noteTag_read.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('NoteTags'));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('4',$result[0]['noteId']); 
        $this->assertEquals('3',$result[0]['userTagId']);     	 
     }
    
    public function testRecordNotExit()
     {
        $model=['id'=>2];
        $tag=new NoteTag();
        $result=$tag->read($model);
        $this->assertEquals('NoteTag is not Exit',$result);          
     }
     public function testCanInsertRecord()
    {
        $model      = array(
            'noteId' => 1,
            'userTagId' =>1
        );

        $notetag=new NoteTag();
        $result=$notetag->create($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/noteTags_after_insert.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('NoteTags'));
        $this->assertEquals(2,$result); 
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
  
}
