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
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__).'/_files/note_seed.xml');
    }
    public function testCanCreateObject()
    {
        $database = new Database();
        $this->assertInstanceOf('Notes\Database\Database', $database);
    }
    public function testCanReadRecord()
    {
        $database = new Database();
        
        $query       = "select id,userId,title,body,createdOn,lastUpdateOn,isDeleted from Notes";
        $placeholder = null;
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $note   = $database->get($params);
        $this->assertEquals('2', count($note));
    }
    public function testCanReadNoteByOnePlaceholder()
    {
        $database = new Database();
        
        $query       = "select id,userId,title,body,createdOn,lastUpdateOn,isDeleted from Notes where id=:id";
        $placeholder = array(
            ':id' => '1'
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $note   = $database->get($params);
        
        $this->assertEquals('PHP', $note[0]['title']);
    }
    public function testCanReadNoteByTwoPlaceholders()
    {
        $database    = new Database();
        $id          = 2;
        $title        = 'PHP5';
        $query       = "select id,userId,title,body,createdOn,lastUpdateOn,isDeleted 
        from Notes where id=:id and title=:title";
        $placeholder = array(
            ':id' => $id,
            ':title' => $title
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->get($params);
        $this->assertEquals('Server scripting language.', $user[0]['body']);
    }
    public function testDeletingRecordFailed()
    {
        $database = new Database();
        $query    = "update Notes set isDeleted=:isDeleted where id=:id";
        $placeholder = array(
            ':id' => 4,
            ':isDeleted' => 1
        );
        $params   = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $result     = $database->post($params);
        
        $this->assertEquals(0, $result['rowCount']);
    }
}
