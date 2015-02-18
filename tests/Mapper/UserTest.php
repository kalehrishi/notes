<?php
namespace Notes\Mapper;

use Notes\Config\Config as Configuration;

use Notes\Mapper\User as UserMapper;

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
        $userMapper = new UserMapper();
        $user       = $userMapper->read(1);
        $this->assertEquals('anusha', $user->firstName);
    }
    public function testCanInsertRecord()
    {
        $input      = array(
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userMapper = new UserMapper();
        $userMapper->create($input);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    public function testCanUpdateRecord()
    {
        $query         = "select id, firstName,lastName,email,password,createdOn from Users";
        $queryTable    = $this->getConnection()->createQueryTable('Users', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_after_update.xml')
        ->getTable("Users");
        $this->assertTablesEqual($expectedTable, $queryTable);
        
    }
}
