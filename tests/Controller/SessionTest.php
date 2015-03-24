<?php
namespace Notes\Controller;

use Notes\Controller\Session as Session;
use Notes\Request\Request as Request;
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
        $data    = '{
                "data": {
                            "email" : "pushpa@marade.com",
                           "password" :"pushpa123"
                        }   
                }';
        $request = new Request();
        $request->setData($data);

        $sessionController = new Session($request);
        
        $response = $sessionController->post();
        
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
        
        $data    = '{
                "data": {
                            "email" : "abcd@gmail.com",
                           "password" :"psd"
                        }   
                }';
        $request = new Request();
        $request->setData($data);

        $sessionController = new Session($request);
        
        $response = $sessionController->post();
    }
    
    /**
     * @test
     *
     **/
    public function it_should_delete_session_if_user_login()
    {
        $data    = '{
                "data": {
                            "authToken" : "abc",
                           "userId" :"1"
                        }   
                }';
        $request = new Request();
        $request->setData($data);

        $sessionController = new Session($request);
        
        $response = $sessionController->delete();
        
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
        $data    = '{
                "data": {
                            "authToken" : "xyz",
                           "userId" :"15"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        $sessionController = new Session($request);
        
        $response = $sessionController->delete();
    }
}
