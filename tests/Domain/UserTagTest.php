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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/userTagDomain_seed.xml');
    }
    
    /**
     * @expectedException        Exception
     * @expectedExceptionMessage Column 'tag' cannot be null
     */
    public function testthrowsExceptionWhenTagDoesNotPresent()
    {
        $input = array(
            'userId' => 2,
            'isDeleted' => 0
        );
        
        $userTagModel = new UserTagModel();
        
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->validation($userTagModel);
    }
    
    /**
    * @expectedException        Exception
    * @expectedExceptionMessage Column 'userId' cannot be null
    */
    public function testthrowsExceptionWhenUserIdDoesNotPresent()
    {
        $input = array(
            'tag' => 'people',
            'isDeleted' => 0
        );
        
        $userTagModel = new UserTagModel();
        
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->validation($userTagModel);
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
        
    }
    
    public function testCanReadTagById()
    {
        $input = array(
            'id' => 2
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->read($userTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertEquals(2, $userTagModel->getId());
        $this->assertEquals(1, $userTagModel->getUserId());
        $this->assertEquals('Tax', $userTagModel->getTag());
        $this->assertEquals(0, $userTagModel->getIsDeleted());
        
    }
    public function testCanUpdateTagById()
    {
        $input = array(
            'id' => 2,
            'userId'=>1,
            'tag'=>'Tag Updated',
            'isDeleted'=>0
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->update($userTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_after_update.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertEquals(2, $userTagModel->getId());
        $this->assertEquals(1, $userTagModel->getUserId());
        $this->assertEquals('Tag Updated', $userTagModel->getTag());
        $this->assertEquals(0, $userTagModel->getIsDeleted());
        
    }

    /**
    * @expectedException         Notes\Exception\ModelNotFoundException
    * @expectedExceptionMessage  Can Not Found Given Model In Database
    */
    public function testTagUpdationFaild()
    {
        $input = array(
            'id' => 2,
            'userId'=>1,
            'tag'=>'Tax',
            'isDeleted'=>0
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->update($userTagModel);     
    }

    public function testCanDeleteTagById()
    {
        $input = array(
            'id' => 3,
            'userId'=>2,
            'tag'=>'People',
            'isDeleted'=>0
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setId($input['id']);
        $userTagModel->setUserId($input['userId']);
        $userTagModel->setTag($input['tag']);
        $userTagModel->setIsDeleted($input['isDeleted']);
        
        
        $userTagDomain = new UserTag();
        $userTagModel  = $userTagDomain->delete($userTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/userTagDomain_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'UserTags'
        ));
        
        $this->assertEquals(3, $userTagModel->getId());
        $this->assertEquals(2, $userTagModel->getUserId());
        $this->assertEquals('People', $userTagModel->getTag());
        $this->assertEquals(1, $userTagModel->getIsDeleted());
        
    }

}
