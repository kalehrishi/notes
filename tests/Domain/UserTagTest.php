<?php

namespace Notes\Domain;

use Notes\Mapper\UserTag as UserTagMapper;

use Notes\Model\UserTag as UserTagModel;

use Notes\Model\User as UserModel;

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
        }
        catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/userTagDomain_seed.xml');
    }
        
    public function testCanCreateTag()
    {
        $input = array(
            'userId' => 3,
            'tag' => 'Create'
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->create($userTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_after_create.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertEquals(4, $userTagModel->getId());
        $this->assertEquals(3, $userTagModel->getUserId());
        $this->assertEquals('Create', $userTagModel->getTag());
        $this->assertEquals(0, $userTagModel->getIsDeleted());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
    * @expectedException         InvalidArgumentException
    * @expectedExceptionMessage  Input should not be null
    */
    public function testThrowsExceptionWhenUserIdIsNull()
    {
        $input = array(
            'tag' => 'Create'
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setTag($input['tag']);
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->create($userTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_after_create.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertEquals(4, $userTagModel->getId());
        $this->assertEquals(3, $userTagModel->getUserId());
        $this->assertEquals('Create', $userTagModel->getTag());
        $this->assertEquals(0, $userTagModel->getIsDeleted());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    public function testCanReadTagByUserId()
    {
        $input = array(
            'userId' => 2
        );
        
        $userModel = new UserModel();
        $userModel->setId($input['userId']);
        
        
        $userTagDomain = new UserTag();
        $userTagCollection  = $userTagDomain->readTagsByUserId($userModel);
           
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        while($userTagCollection->hasNext()) {
        $this->assertEquals(3, $userTagCollection->getRow(0)->getId());
        $this->assertEquals(2, $userTagCollection->getRow(0)->getUserId());
        $this->assertEquals('People', $userTagCollection->getRow(0)->getTag());
        $this->assertEquals(0, $userTagCollection->getRow(0)->getIsDeleted());
        $userTagCollection->next();
        } 
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
    * @expectedException         Notes\Exception\ModelNotFoundException
    * @expectedExceptionMessage  Can Not Found Given Model In Database
    */
    public function testThrowsExceptionWhenUserIdDoesNotExist()
    {
        $input = array(
            'userId' => 54
        );
        
        $userModel = new UserModel();
        $userModel->setId($input['userId']);
        
        
        $userTagDomain = new UserTag();
        $userTagCollection  = $userTagDomain->readTagsByUserId($userModel);
    }

    public function testCanReadById()
    {
        $input = array(
            'id' => 1
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        
        
        $userTagDomain = new UserTag();
        $userTagResultSet  = $userTagDomain->readTagById($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertEquals(1, $userTagResultSet->getId());
        $this->assertEquals(1, $userTagResultSet->getUserId());
        $this->assertEquals('Import package', $userTagResultSet->getTag());
        $this->assertEquals(0, $userTagResultSet->getIsDeleted());
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
}
