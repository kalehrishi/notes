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
        } catch (\PDOException $e) {
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
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->read($userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTags_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('Import package', $userTagModel->getTag());
        $this->assertEquals('1', $userTagModel->getUserId());
        $this->assertEquals('0', $userTagModel->getIsDeleted());
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
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->read($userTagModel);
        
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
    /**
     * @expectedException              Exception
     * @expectedExceptionMessage       Column 'userId' cannot be null
     */
    
    public function testInsertionFailed()
    {
        $input        = array(
            'tag' => 'Tag for record 2'
        );
        $userTagModel = new UserTagModel();
        $userTagModel->setTag($input['tag']);
        
        $userTagMapper = new UserTag();
        $userTagModel  = $userTagMapper->create($userTagModel);
        
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
     * @expectedException              Exception
     * @expectedExceptionMessage       Failed
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
     * @expectedException              Exception
     * @expectedExceptionMessage       Failed
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
