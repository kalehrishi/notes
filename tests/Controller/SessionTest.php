<?php

namespace Notes\Domain;

use Notes\Controller\Session as Session;
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
        }
        catch (\PDOException $e) {
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
        $userInput = array(
            'email' => 'pushpa@marade.com',
            'password' => 'pushpa123'
            
        );
        
        $sessionController = new Session();
        
        $response = $sessionController->post($userInput);
    }
    
    /**
     * @test
     *
     **/
    public function it_should_delete_session()
    {
        $input = array(
            'userId' => 2,
            'authToken' => 'pqr'
        );
        
        $sessionController = new Session();
        $response          = $sessionController->delete($input);
    }
}
