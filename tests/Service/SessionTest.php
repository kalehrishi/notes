<?php

namespace Notes\Service;

use Notes\Service\Session as Session;

use Notes\Model\Session as sessionModel;

use Notes\Model\User as UserModel;

use Notes\Config\Config as Configuration;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class SessionTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_seed.xml');
    }
    /**
    * @test
    *
    **/
    public function it_should_login_with_valid_email_password()
    {
        $userInput = array(
            'email' => 'pushpa@marade.com',
            'password' => 'Pushpa@123'
            
        );
        
        $userModel = new UserModel();

        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);

        $sessionModel = new sessionModel();
        $sessionService   = new Session();

        $sessionModel    = $sessionService->login($userInput);
        
        $this->assertEquals(4, $sessionModel->getId());
        $this->assertEquals(3, $sessionModel->getUserId());
        $this->assertEquals(null, $sessionModel->getExpiredOn());
        $this->assertEquals(0, $sessionModel->getIsExpired());
    }
    
     /**
    * @test
    *
    **/
    public function it_should_read_session_by_userId_and_authToken()
    {
        $input        = array(
            'userId' => 2,
            'authToken' => 'pqr'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setUserId($input['userId']);
        $sessionModel->setAuthToken($input['authToken']);

        $sessionService   = new Session();

        $sessionModel    = $sessionService->isValid($sessionModel);

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

    /**
    * @test
    *
    **/
    public function it_should_read_session_by_id()
    {
        $input        = array(
            'id' => 2
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);

        $sessionService   = new Session();

        $sessionModel    = $sessionService->read($sessionModel);

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

     /**
    * @test
    *
    **/
    public function it_should_logout()
    {
        $input        = array(
            'id' => '1',
            'userId' => '1',
            'isExpired' => '1'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);
        $sessionModel->setUserId($input['userId']);
        $sessionModel->setIsExpired($input['isExpired']);

        $sessionService   = new Session();

        $sessionModel    = $sessionService->logout($sessionModel);
        $this->assertEquals(1, $sessionModel->getId());
        $this->assertEquals(1, $sessionModel->getUserId());
        $this->assertEquals(1, $sessionModel->getIsExpired());
    }
    

    /**
     * @test
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function it_should_throw_exception_while_logout_without_userId()
    {
        $input        = array(
            'id' => 1,
            'createdOn' => '2015-01-29 20:59:59'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);
        $sessionModel->setCreatedOn($input['createdOn']);
       
        $sessionService = new Session();

        $sessionModel  = $sessionService->logout($sessionModel);
    }
    
    /**
     * @test
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function it_should_throw_exception_with_invalid_id()
    {
        $input        = array(
            'id' => 10
        );
        $sessionModel = new sessionModel();

        $sessionModel->setId($input['id']);

        $sessionService = new Session();

        $sessionModel  = $sessionService->read($sessionModel);
    }
    
    /**
     * @test
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function it_should_throw_exception_with_invalid_authToken_userId()
    {
        $input        = array(
            'userId' => 15,
            'authToken' => 'xyz'
        );
        $sessionModel = new sessionModel();

        $sessionModel->setUserId($input['userId']);
        $sessionModel->setAuthToken($input['authToken']);

        $sessionService = new Session();

        $sessionModel  = $sessionService->isValid($sessionModel);
    }

    /**
     * @test
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function it_should_throw_exception_with_invalid_email_password()
    {
        $userInput = array(
            'email' => 'abcd@gmail.com',
            'password' => 'Joy%hj5487'
        );
        $userModel = new UserModel();

        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);

        $sessionService = new Session();
        $sessionModel  = $sessionService->login($userInput);
    }
}
