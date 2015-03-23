<?php

namespace Notes\Controller;

use Notes\Controller\Session as Session;

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
    public function it_should_create_session_with_valid_email_password()
    {
        $userInput         = array(
            'email' => 'pushpa@marade.com',
            'password' => 'pushpa123'
            
        );
        $sessionController = new Session();
        
        $response = $sessionController->post($userInput);
        
        $this->assertEquals(4, $response->getId());
        $this->assertEquals(3, $response->getUserId());
        $this->assertEquals(null, $response->getExpiredOn());
        $this->assertEquals(0, $response->getIsExpired());
        
    }
    
    /**
     * @test
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function it_should_throw_exception_with_invalid_email_password()
    {
        $input = array(
            'email' => 'abcd@gmail.com',
            'password' => 'psd'
        );
        
        $sessionController = new Session();
        
        $sessionModel = $sessionController->post($input);
    }
    
    /**
     * @test
     *
     **/
    public function it_should_delete_session_if_user_login()
    {
        $input             = array(
            'authToken' => 'abc',
            'userId' => 1
        );
        $sessionController = new Session();

        $response          = $sessionController->delete($input);

        $this->assertEquals(1, $response->getId());
        $this->assertEquals(1, $response->getUserId());
        $this->assertEquals(1, $response->getIsExpired());
    }

    /**
     * @test
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function it_should_throw_exception_with_invalid_authToken_userId()
    {
        $input             = array(
            'userId' => 15,
            'authToken' => 'xyz'
        );
        $sessionController = new Session();

        $response = $sessionController->delete($input);
    } 
}
