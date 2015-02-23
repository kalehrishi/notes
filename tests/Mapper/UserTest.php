<?php
namespace Notes\Mapper;

use Notes\Config\Config as Configuration;

use Notes\Mapper\User as UserMapper;

use Notes\Model\User as UserModel;

class UserTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function getConnection()
    {
        $config     = new Configuration();
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_seed.xml');
    }
    public function testCanReadRecordById()
    {
        $input      = array(
            'id' => 1
        );
        $userModel  = new UserModel();
        $userMapper = new UserMapper();
        $userModel->setId($input['id']);
        $userModel       = $userMapper->read($userModel);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('1', $userModel->getId());
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    public function testUserIdDoesNotExist()
    {
        
        $input = array(
            'id' => 4
        );
        
        $userModel  = new UserModel($input);
        $userMapper = new UserMapper();
        $userModel->setId($input['id']);
        $userModel = $userMapper->read($userModel);
    }
    
    public function testCanInsertRecord()
    {
        $input     = array(
            'firstName' => 'kirti',
            'lastName' => 'ramani',
            'email' => 'kirti.6@gmail.com',
            'password' => 'sfhsk1226',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userModel = new UserModel($input);
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        $userMapper      = new UserMapper();
        $resultset       = $userMapper->create($userModel);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertEquals('kirti', $userModel->getFirstName());
        $this->assertEquals('ramani', $userModel->getLastName());
        $this->assertEquals('kirti.6@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1226', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    public function testInsertionFailed()
    {
        
        $input = array(
            'firstName' => 'priyanka',
            'lastName' => 'kumar',
            'email' => 'kumar.6@gmail.com',
            'password' => 'sfhsk1229',
            'createdOn' => '2014-10-30 20:59:59'
        );
        
        
        $userModel  = new UserModel();
        $userMapper = new UserMapper();
        
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        
        
    }
    
    
    public function testCanUpdateRecord()
    {
        $input     = array(
            'id' => 1,
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userModel = new UserModel($input);
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        $userMapper      = new UserMapper();
        $resultset       = $userMapper->create($userModel);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_update.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    public function testUpdationFailed()
    {
        
        $input = array(
            'firstName' => 'priyanka',
            'lastName' => 'kumar',
            'email' => 'kumar.6@gmail.com',
            'password' => 'sfhsk1229',
            'createdOn' => '2014-10-30 20:59:59'
        );
        
        
        $userModel  = new UserModel();
        $userMapper = new UserMapper();
        
        $userModel->setFirstName($input['firstName']);
        $userModel->setLastName($input['lastName']);
        $userModel->setEmail($input['email']);
        $userModel->setPassword($input['password']);
        $userModel->setCreatedOn($input['createdOn']);
        
        
    }
}
