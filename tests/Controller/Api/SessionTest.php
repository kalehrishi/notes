<?php
namespace Notes\Controller\Api;
use Notes\Controller\Api\Session as Session;
use Notes\Request\Request as Request;
use Notes\Config\Config as Configuration;
use Notes\Response\Response as Response;
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
                            "email" : "anusha@gmail.com",
                           "password" :"anushA@h21"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        
        $sessionController = new Session($request);
        
        $data = $sessionController->post();
        $this->assertNotNull($data);

        
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
    public function it_should_delete_session_if_user_is_already_login()
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
        $this->assertNotNull($data);
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