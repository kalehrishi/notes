<?php

namespace Notes\Mapper;

use Notes\Config\Config as Configuration;


class UserTagTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__).'/_files/userTags_seed.xml');
    }


    public function testCanReadRecordById()
     {
        $model=['id'=>1];
        $tag=new UserTag();
        $result=$tag->read($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/userTags_seed.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('UserTags'));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('Import package',$result[0]['tag']); 
        $this->assertEquals('1',$result[0]['userId']);     	 
     }
    public function testRecordNotExit()
     {
        $model=['id'=>2];
        $tag=new UserTag();
        $result=$tag->read($model);
        $this->assertEquals('UserTag is not Exit',$result);     	 
     }

    public function testCanInsertRecord()
    {
        $model      = array(
            'id' => 1,
            'tag' => 'Tag for record 2'
        );

        $tag=new UserTag();
        $result=$tag->create($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/userTags_after_insert.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('UserTags'));
        $this->assertEquals(2,$result); 
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
  
    public function testCanDeleteRecord()
    {
        $model      = array(
            'id' => 1
        );

        $tag=new UserTag();
        $result=$tag->delete($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/userTags_after_delete.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('UserTags'));
        $this->assertEquals('Successfuly deleted',$result); 
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    public function testDeletionOfRecordFailed()
    {
        $model      = array(
            'id' => 2
        );

        $tag=new UserTag();
        $result=$tag->delete($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/userTags_delete_failed.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('UserTags'));
        $this->assertEquals('Deletion Failed',$result); 
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    public function testCanUpdateRecord()
    {
        $model      = array(
            'id' => 1,
            'tag'=>"Tag Updated"
        );

        $tag=new UserTag();
        $result=$tag->update($model);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/userTags_after_update.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('UserTags'));
        $this->assertEquals('Successfuly Updated',$result); 
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }




}