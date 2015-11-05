<?php

namespace Notes\Mapper;

use Notes\Model\UserTag as UserTagModel;

use Notes\Config\Config as Configuration;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class UserTagTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/userTags_seed.xml');
    }
    
    public function testCanReadById()
    {
        $input        = array(
            'id' => 1
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        
        $userTagMapper = new UserTag();
        $actualResultSet = $userTagMapper->readTagById($userTagModel);
        
        $this->assertEquals(1, $actualResultSet->getId());
        $this->assertEquals(1, $actualResultSet->getUserId());
        $this->assertEquals('Import package', $actualResultSet->getTag());
        $this->assertEquals(0, $actualResultSet->getIsDeleted());
        
    }
    /**
    * @expectedException         Notes\Exception\ModelNotFoundException
    * @expectedExceptionMessage  Can Not Found Given Model In Database
    */
    public function testThrowsExceptionWhenIdDoesNotExists()
    {
        $input        = array(
            'id' => 2
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->readTagById($userTagModel);
        
    }
    public function testCanReadRecordByUserId()
    {
        $input        = array(
            'userId' => 1
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setUserId($input['userId']);
        
        
        $userTagMapper = new UserTag();
        $userTagCollection = $userTagMapper->readTagsByUserId($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
       
        while ($userTagCollection->hasNext()) {
            $this->assertEquals(1, $userTagCollection->getRow(0)->getId());
            $this->assertEquals(1, $userTagCollection->getRow(0)->getUserId());
            $this->assertEquals('Import package', $userTagCollection->getRow(0)->getTag());
            $this->assertEquals(0, $userTagCollection->getRow(0)->getIsDeleted());
            $userTagCollection->next();
        }
    }
    
    public function testCanInsertRecord()
    {
        $input        = array(
            'userId' => 1,
            'tag' => 'Tag for record 2'
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->create($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertEquals(2, $userTagModel->getId());
        $this->assertEquals(1, $userTagModel->getUserId());
        $this->assertEquals('Tag for record 2', $userTagModel->getTag());
        $this->assertEquals(0, $userTagModel->getIsDeleted());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    
    public function testCanDeleteRecord()
    {
        $input        = array(
            'id' => 1,
            'userId'=>1,
            'tag'=>'Import package',
            'isDeleted'=>1
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
    
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->update($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertEquals(1, $userTagModel->getId());
        $this->assertEquals(1, $userTagModel->getUserId());
        $this->assertEquals('Import package', $userTagModel->getTag());
        $this->assertEquals(1, $userTagModel->getIsDeleted());
        
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
            'userId'=>1,
            'tag'=>'Import package',
            'isDeleted'=>1
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->update($userTagModel);
    }
    
    public function testCanUpdateRecord()
    {
        $input = array(
            'id' => 1,
            'userId'=>1,
            'tag' => "Tag Updated",
            'isDeleted'=>0
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->update($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_after_update.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertEquals(1, $userTagModel->getId());
        $this->assertEquals(1, $userTagModel->getUserId());
        $this->assertEquals('Tag Updated', $userTagModel->getTag());
        $this->assertEquals(0, $userTagModel->getIsDeleted());
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
    * @expectedException         Notes\Exception\ModelNotFoundException
    * @expectedExceptionMessage  Can Not Found Given Model In Database
    */
    
    public function testUpdationFailed()
    {
        $input = array(
            'id' => 2,
            'userId'=>1,
            'tag' => "Tag Updated",
            'isDeleted'=>0
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
                
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->update($userTagModel);
    }
}
