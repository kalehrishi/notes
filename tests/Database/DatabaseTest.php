<?php
namespace Notes\Database;

use Notes\Config\Config as Configuration;

class DatabaseTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $connection;
    
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
        }
        catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {

        return $this->createXMLDataSet(dirname(__FILE__).'/_files/database_seed.xml');

    }
    public function testCanCreateObject()
    {
        $database = new Database();
        $this->assertInstanceOf('Notes\Database\Database', $database);
    }
    public function testCanReadRecord()
    {
        $database = new Database();
        
        $query       = "select id,firstName,lastName,isDeleted from DbTest";
        $placeholder = null;
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $note   = $database->get($params);
        $this->assertEquals('2', count($note));
    }
    public function testCanReadByOnePlaceholder()
    {
        $database = new Database();
        
        $query       = "select id,firstName,lastName,isDeleted from DbTest where id=:id";
        $placeholder = array(
            ':id' => '1'
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $resultset   = $database->get($params);
        $this->assertEquals('1', count($resultset));
        $this->assertEquals(1, $resultset[0]['id']);
        $this->assertEquals('John', $resultset[0]['firstName']);
        $this->assertEquals('Doe', $resultset[0]['lastName']);
        $this->assertEquals(1, $resultset[0]['isDeleted']);
    }
    public function testCanReadByTwoPlaceholders()
    {
        $database    = new Database();
        $id          = 2;

        $title       = 'PHP5';
        $query       = "select id,userId,title,body,createdOn,lastUpdateOn,isDeleted 
        from Notes where id=:id and title=:title";
        $firstName        = 'Jerry';
        $query       = "select id,firstName,lastName,isDeleted from DbTest where id=:id and firstName=:firstName";

        $placeholder = array(
            ':id' => $id,
            ':firstName' => $firstName
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $resultset   = $database->get($params);
        $this->assertEquals('Tom', $resultset[0]['lastName']);
        $this->assertEquals(0, $resultset[0]['isDeleted']);
    }
    public function testDeletingRecordFailed()
    {
        $database = new Database();
        $query    = "update DbTest set isDeleted=:isDeleted where id=:id";

        $placeholder = array(
            ':id' => 4,
            ':isDeleted' => 1
        );
        $params      = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );

        $result      = $database->post($params);

        $resultset     = $database->post($params);

        $this->assertEquals(0, $resultset['rowCount']);
    }
}
