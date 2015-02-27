<?php

namespace Notes\Domain;

use Notes\Mapper\Session as SessionMapper;
use Notes\Model\Session as SessionModel;
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
    /*
    public function testCanCreateSession()
    {
    $input        = array(
    'userId' => 3,
    'authToken' => 'pqr',
    'createdOn' => '2015-01-29 20:59:59',
    'expiredOn' => '2015-01-29 20:59:59'
    );
    $SessionModel = new SessionModel();
    $SessionModel->setUserId($input['userId']);
    $SessionModel->setAuthToken($input['authToken']);
    $SessionModel->setCreatedOn($input['createdOn']);
    $SessionModel->setExpiredOn($input['expiredOn']);
    $SessionDomain   = new Session();
    $SessionModel    = $SessionDomain->create($SessionModel);
    $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/Session_after_create.xml');
    $actualDataSet   = $this->getConnection()->createDataSet(array(
    'Sessions'
    ));
    $this->assertEquals(4, $SessionModel->getId());
    $this->assertEquals(3, $SessionModel->getUserId());
    $this->assertEquals('pqr', $SessionModel->getAuthToken());
    $this->assertEquals('2015-01-29 20:59:59', $SessionModel->getCreatedOn());
    $this->assertEquals('2015-01-29 20:59:59', $SessionModel->getExpiredOn());
    $this->assertEquals(0, $SessionModel->getIsExpired());
    }
    */
    public function testCanReadSessionByUserIdAndAuthToken()
    {
        $input        = array(
            'userId' => 2,
            'authToken' => 'pqr'
        );
        $SessionModel = new SessionModel();
        $SessionModel->setUserId($input['userId']);
        $SessionModel->setAuthToken($input['authToken']);
        $SessionDomain   = new Session();
        $SessionModel    = $SessionDomain->getSessionByAuthTokenAndUserId($SessionModel);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertEquals(2, $SessionModel->getId());
        $this->assertEquals(2, $SessionModel->getUserId());
        $this->assertEquals('pqr', $SessionModel->getAuthToken());
        $this->assertEquals('2014-10-29 20:59:59', $SessionModel->getCreatedOn());
        $this->assertEquals('2014-10-29 20:59:59', $SessionModel->getExpiredOn());
        $this->assertEquals(1, $SessionModel->getIsExpired());
    }
    
    public function testCanReadSession()
    {
        $input        = array(
            'id' => 2
        );
        $SessionModel = new SessionModel();
        $SessionModel->setId($input['id']);
        $SessionDomain   = new Session();
        $SessionModel    = $SessionDomain->read($SessionModel);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertEquals(2, $SessionModel->getId());
        $this->assertEquals(2, $SessionModel->getUserId());
        $this->assertEquals('pqr', $SessionModel->getAuthToken());
        $this->assertEquals('2014-10-29 20:59:59', $SessionModel->getCreatedOn());
        $this->assertEquals('2014-10-29 20:59:59', $SessionModel->getExpiredOn());
        $this->assertEquals(1, $SessionModel->getIsExpired());
    }

    public function testCanDeleteSession()
    {
        $input        = array(
            'id' => '1',
            'userId' => '1',
            'expiredOn' => '2015-01-01 01:00:01',
            'isExpired' => '1'
        );
        $SessionModel = new SessionModel();
        $SessionModel->setId($input['id']);
        $SessionModel->setUserId($input['userId']);
        $SessionModel->setExpiredOn($input['expiredOn']);
        $SessionModel->setIsExpired($input['isExpired']);
        $SessionDomain   = new Session();
        $SessionModel    = $SessionDomain->delete($SessionModel);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/session_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertEquals(1, $SessionModel->getId());
        $this->assertEquals(1, $SessionModel->getUserId());
        $this->assertEquals('2015-01-01 01:00:01', $SessionModel->getExpiredOn());
        $this->assertEquals(1, $SessionModel->getIsExpired());
    }
    
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testthrowsExceptionWhenUserIdDoesNotExist()
    {
        $input        = array(
            'createdOn' => '2015-01-29 20:59:59',
            'expiredOn' => '2015-01-29 20:59:59'
        );
        $SessionModel = new SessionModel();
        $SessionModel->setCreatedOn($input['createdOn']);
        $SessionModel->setExpiredOn($input['expiredOn']);
        $SessionDomain = new Session();
        $SessionModel  = $SessionDomain->read($SessionModel);
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
        $SessionModel = new SessionModel();
        $SessionModel->setId($input['id']);
        $SessionDomain = new Session();
        $SessionModel  = $SessionDomain->read($SessionModel);
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
        $SessionModel = new SessionModel();
        $SessionModel->setUserId($input['userId']);
        $SessionModel->setAuthToken($input['authToken']);
        $SessionDomain   = new Session();
        $SessionModel    = $SessionDomain->getSessionByAuthTokenAndUserId($SessionModel);
    }
}
