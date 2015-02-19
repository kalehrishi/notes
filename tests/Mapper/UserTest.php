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
        $userMapper = new UserMapper();
        $userModel  = new UserModel($input);
        $resultset  = $userMapper->read($userModel);
        print_r($resultset);
    }
    public function testCanInsertRecord()
    {
        $input      = array(
            'firstName' => 'kirti',
            'lastName' => 'ramani',
            'email' => 'kirti.6@gmail.com',
            'password' => 'sfhsk1226',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userMapper = new UserMapper();
        $userModel  = new UserModel($input);
        $userMapper->create($userModel);
        
        $query         = "select id, firstName,lastName,email,password,createdOn from Users";
        $queryTable    = $this->getConnection()->createQueryTable('Users', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_after_insert.xml')
        ->getTable("Users");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    
    public function testCanUpdateRecord()
    {
        $input      = array(
            'id' => 1,
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userMapper = new UserMapper();
        $userModel  = new UserModel($input);
        $userMapper->update($userModel);
        $query         = "select id,firstName,lastName,email,password,createdOn from Users";
        $queryTable    = $this->getConnection()->
        createQueryTable('Users', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_after_update.xml')->
        getTable("Users");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    public function testCanUpdateRecordByFirstNameAndLastName()
    {
        
        $input      = array(
            'id' => 1,
            'firstName' => 'anusha',
            'lastName' => 'hiremath'
        );
        $userMapper = new UserMapper();
        $userModel  = new UserModel($input);
        $userMapper->update($userModel);
        $query         = "select id,firstName,lastName,email,
        password,createdOn from Users";
        $queryTable    = $this->getConnection()->createQueryTable('Users', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_after_update.xml')->
        getTable("Users");
        $this->assertTablesEqual($expectedTable, $queryTable);
        
    }
    public function testCanUpdateRecordByEmailAndPassword()
    {
        $userMapper = new UserMapper();
        $input      = array(
            'id' => 1,
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223'
        );
        $userMapper = new UserMapper();
        $userModel  = new UserModel($input);
        $userMapper->update($userModel);
        $query         = "select id,firstName,lastName,email,password,createdOn from Users";
        $queryTable    = $this->getConnection()->createQueryTable('Users', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_after_update.xml')->
        getTable("Users");
        $this->assertTablesEqual($expectedTable, $queryTable);
        
    }
}
