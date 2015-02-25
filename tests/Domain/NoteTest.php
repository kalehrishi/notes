<?php
namespace Notes\Domain;

use Notes\Domain\Note as NoteDomain;
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
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("set foreign_key_checks=0");
            return $this->createDefaultDBConnection($this->connection, $dbName);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/domain_note_seed.xml');
    }
    
    public function testCanCreateNote()
    {
        $input = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($input);
        
        $this->assertEquals(3, $actualResultSet->id);
        $this->assertEquals(1, $actualResultSet->userId);
        $this->assertEquals('Exception', $actualResultSet->title);
        $this->assertEquals('Creating a custom exception handler is quite simple.', $actualResultSet->body);
        
        $query           = "select id, userId, title, body, isDeleted from Notes";
        $actualDataSet   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/domain_note_after_insert.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedDataSet, $actualDataSet);
    }
    
    public function testCanDelete()
    {
        $input = array(
            'id' => 2,
            'isDeleted' => 1
        );
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->delete($input);
        
        $this->assertEquals(1, $actualResultSet->isDeleted);
        
    }
    
    public function testCanUpdate()
    {
        $input = array(
            'id' => 1,
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->update($input);
        
        $this->assertEquals("Updated Successfully", $actualResultSet);
        $query           = "select id, title, body from Notes";
        $actualDataSet   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/domain_note_after_update.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedDataSet, $actualDataSet);
        
    }
    
    public function testReadById()
    {
        $input           = array(
            'id' => 1
        );
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->read($input);
        
        $this->assertEquals(1, $actualResultSet->id);
        $this->assertEquals('PHP', $actualResultSet->title);
        $this->assertEquals('Preprocessor Hypertext', $actualResultSet->body);
    }
}
