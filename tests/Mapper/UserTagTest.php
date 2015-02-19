<?php

namespace Notes\Mapper;

use Notes\Model\UserTag as UserTagModel;

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
        }
        catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/userTags_seed.xml');
    }
    
    
    public function testCanReadRecordById()
    {
        $input        = array(
            'id' => 1
        );
        $userTagModel = new UserTagModel($input);
        
        
        $userTagMapper = new UserTag();
        $result         = $userTagMapper->read($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('Import package', $result->tag);
        $this->assertEquals('1', $result->userId);
    }
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       UserTagId Does Not Present
     */
    public function testUserTagIdDoesNotExists()
    {
        $input        = array(
            'id' => 2
        );
        $userTagModel = new UserTagModel($input);
        
        
        $userTagMapper = new UserTag();
        $result        = $userTagMapper->read($userTagModel);
        
    }
    
    public function testCanInsertRecord()
    {
        $input        = array(
            'userId' => 1,
            'tag' => 'Tag for record 2'
        );
        $userTagModel = new UserTagModel($input);
        
        $userTagMapper = new UserTag();
        $result         = $userTagMapper->create($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertEquals(2, $result->id);
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       Column 'userId' cannot be null
     */
    
    public function testInsertionFailed()
    {
        $input        = array(
            'tag' => 'Tag for record 2'
        );
        $userTagModel = new UserTagModel($input);
        
        $userTagMapper = new UserTag();
        $model         = $userTagMapper->create($userTagModel);
        
    }
    
    public function testCanDeleteRecord()
    {
        $input        = array(
            'id' => 1
        );
        $userTagModel = new UserTagModel($input);
        
        
        $userTagMapper = new UserTag();
        $result        = $userTagMapper->delete($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertEquals('Successfuly deleted', $result);
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       UserTagId Does Not Present
     */
    public function testDeletionFailed()
    {
        $input        = array(
            'id' => 2
        );
        $userTagModel = new UserTagModel($input);
        
        
        $userTagMapper = new UserTag();
        $result        = $userTagMapper->delete($userTagModel);
    }
    
    public function testCanUpdateRecord()
    {
        $input = array(
            'id' => 1,
            'tag' => "Tag Updated"
        );
        
        $userTagModel = new UserTagModel($input);
        
        $userTagMapper = new UserTag();
        $result        = $userTagMapper->update($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_after_update.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertEquals('Successfuly Updated', $result);
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       Updation Failed
     */
    
    public function testUpdationFailed()
    {
        $input = array(
            'id' => 2,
            'tag' => "Tag Updated"
        );
        
        $userTagModel = new UserTagModel($input);
        
        $userTagMapper = new UserTag();
        $result        = $userTagMapper->update($userTagModel);
        
        
    }
    
}
