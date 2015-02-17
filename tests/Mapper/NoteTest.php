<?php
namespace Notes;

use Notes\Mapper\Note as NoteMapper;
use Notes\Config\Config as Configuration;

class NoteTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $connection;
    
    public function getConnection()
    {
        $config     = new Configuration("app/Config/config.json");
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_seed.xml');
    }
    
    public function testAddEntry()
    {
        $input         = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteMapper    = new NoteMapper();
        $resultset     = $noteMapper->create($input);
        $query         = "select id, userId, title, body,isDeleted from Notes";
        $queryTable    = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_insert.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    public function testDeleteEntry()
    {
        $noteMapper    = new NoteMapper();
        $resultset     = $noteMapper->delete('2');
        $query         = "select id, userId, title, body,isDeleted from Notes";
        $queryTable    = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_delete.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    public function testCanFailedForInvalidId()
    {
        $noteMapper = new NoteMapper();
        $resultset  = $noteMapper->delete('4');
        $this->assertEquals(0, $resultset['rowCount']);
    }

    public function testCanReadByTitle()
    {
        $noteMapper = new NoteMapper();
        $resultset  = $noteMapper->read('2');
        $this->assertEquals("PHP5", $resultset->title);
    }
}
