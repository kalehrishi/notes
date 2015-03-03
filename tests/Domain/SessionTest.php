<?php

namespace Notes\Domain;

use Notes\Domain\Session as Session;
use Notes\Model\Session as sessionModel;
use Notes\Model\User as UserModel;
use Notes\Config\Config as Configuration;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class SessionTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_seed.xml');
    }
    
    public function testCanCreateSession()
    {
        $userInput = array(
            'email' => 'pushpa@marade.com',
            'password' => 'pushpa123'
            
        );
        
        $userModel = new UserModel();

        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);

        $input        = array(
            'createdOn' => '2015-01-29 20:59:59',
            'expiredOn' => '2015-01-29 20:59:59'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setCreatedOn($input['createdOn']);
        $sessionModel->setExpiredOn($input['expiredOn']);
        
        $sessionDomain   = new Session();

        $sessionModel    = $sessionDomain->create($userModel, $sessionModel);
        
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/Session_after_create.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'

        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(4, $sessionModel->getId());
        $this->assertEquals(3, $sessionModel->getUserId());
        $this->assertEquals('c24f708834cef1827a9f5bc9ec240d0d', $sessionModel->getAuthToken());
        $this->assertEquals('2015-01-29 20:59:59', $sessionModel->getCreatedOn());
        $this->assertEquals('2015-01-29 20:59:59', $sessionModel->getExpiredOn());
        $this->assertEquals(0, $sessionModel->getIsExpired());
    }
    
    public function testCanReadSessionByUserIdAndAuthToken()
    {
        $input        = array(
            'userId' => 2,
            'authToken' => 'pqr'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setUserId($input['userId']);
        $sessionModel->setAuthToken($input['authToken']);

        $SessionDomain   = new Session();

        $sessionModel    = $SessionDomain->getSessionByAuthTokenAndUserId($sessionModel);

        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(2, $sessionModel->getId());
        $this->assertEquals(2, $sessionModel->getUserId());
        $this->assertEquals('pqr', $sessionModel->getAuthToken());
        $this->assertEquals('2014-10-29 20:59:59', $sessionModel->getCreatedOn());
        $this->assertEquals('2014-10-29 20:59:59', $sessionModel->getExpiredOn());
        $this->assertEquals(1, $sessionModel->getIsExpired());
    }
    
    public function testCanReadSession()
    {
        $input        = array(
            'id' => 2
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);

        $SessionDomain   = new Session();
        $sessionModel    = $SessionDomain->read($sessionModel);

        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(2, $sessionModel->getId());
        $this->assertEquals(2, $sessionModel->getUserId());
        $this->assertEquals('pqr', $sessionModel->getAuthToken());
        $this->assertEquals('2014-10-29 20:59:59', $sessionModel->getCreatedOn());
        $this->assertEquals('2014-10-29 20:59:59', $sessionModel->getExpiredOn());
        $this->assertEquals(1, $sessionModel->getIsExpired());
    }
    
    public function testCanDeleteSession()
    {
        $input        = array(
            'id' => '1',
            'userId' => '1',
            'expiredOn' => '2015-01-01 01:00:01',
            'isExpired' => '1'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);
        $sessionModel->setUserId($input['userId']);
        $sessionModel->setExpiredOn($input['expiredOn']);
        $sessionModel->setIsExpired($input['isExpired']);

        $SessionDomain   = new Session();

        $sessionModel    = $SessionDomain->delete($sessionModel);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/session_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(1, $sessionModel->getId());
        $this->assertEquals(1, $sessionModel->getUserId());
        $this->assertEquals('2015-01-01 01:00:01', $sessionModel->getExpiredOn());
        $this->assertEquals(1, $sessionModel->getIsExpired());
    }
    
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenUserIdIsNull()
    {
        $input        = array(
            'id' => 1,
            'createdOn' => '2015-01-29 20:59:59',
            'expiredOn' => '2015-01-29 20:59:59'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);
        $sessionModel->setCreatedOn($input['createdOn']);
        $sessionModel->setExpiredOn($input['expiredOn']);

        $SessionDomain = new Session();

        $sessionModel  = $SessionDomain->delete($sessionModel);
    }
    
    /**
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    
    public function testThrowsExceptionWhenSessionIdDoesNotExist()
    {
        $input        = array(
            'id' => 10
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);

        $SessionDomain = new Session();

        $sessionModel  = $SessionDomain->read($sessionModel);
    }
    /**
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function testThrowsExceptionWhenAuthTokenAndUserIdNotExist()
    {
        $input        = array(
            'userId' => 15,
            'authToken' => 'xyz'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setUserId($input['userId']);
        $sessionModel->setAuthToken($input['authToken']);

        $SessionDomain = new Session();

        $sessionModel  = $SessionDomain->getSessionByAuthTokenAndUserId($sessionModel);
    }

    /**
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function testhrowsExceptionWhenEmailAndPasswordNotExist()
    {
        $userInput = array(
            'email' => 'abcd@gmail.com',
            'password' => 'psd'
        );
        $userModel = new UserModel();

        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);

        $input        = array(
            'authToken' => 'pqr',
            'createdOn' => '2015-01-29 20:59:59',
            'expiredOn' => '2015-01-29 20:59:59'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setAuthToken($input['authToken']);
        $sessionModel->setCreatedOn($input['createdOn']);
        $sessionModel->setExpiredOn($input['expiredOn']);
        
        $sessionDomain = new Session();
        
        $sessionModel  = $sessionDomain->create($userModel, $sessionModel);
    }
}
