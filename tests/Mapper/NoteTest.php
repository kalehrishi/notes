<?php
namespace Notes;

use Notes\Mapper\Note as NoteMapper;
use Notes\Model\Note as NoteModel;
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
    
    public function testCanUpdateEntryByTitleAndBody()
    {
        $input      = array(
            'id' => 1,
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $actualResultset = $noteMapper->update($noteModel);
        $this->assertEquals("Updated Successfully", $actualResultset);
        $query             = "select id, title, body from Notes";
        $actualDataSet   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_update.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedDataSet, $actualDataSet);
    }
    
    public function testCanFailedToUpdateByNotPassingNoteId()
    {
        $input      = array(
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $actualResultset = $noteMapper->update($noteModel);
        $this->assertEquals("No query results for Note model.", $actualResultset);
        
    }
    
    public function testAddEntry()
    {
        $input      = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteMapper = new NoteMapper();
        
        $noteModel = new NoteModel($input);
        $actualResultset = $noteMapper->create($noteModel);
        $expectedResultset = 3;
        $this->assertEquals($expectedResultset, $actualResultset->id);
    }
    
    public function testCanFailedForAddEntry()
    {
        $input      = array(
            'userId' => 1,
            'body' => 'Insert Data Into MySQL Using PDO'
        );
        $noteMapper = new NoteMapper();
        
        $noteModel = new NoteModel($input);
        $actualResultset = $noteMapper->create($noteModel);
        $this->assertEquals("No query results for Note model.", $actualResultset);
    }
    
    public function testDeleteEntry()
    {
        $input      = array(
            'id' => 2,
            'isDeleted' => 1
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $actualResultset = $noteMapper->delete($noteModel);
        $this->assertEquals(1, $actualResultset->isDeleted);
        
        $query             = "select id,userId, title, body, isDeleted from Notes";
        $actualDataSet   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_delete.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedDataSet, $actualDataSet);
    }
    
    public function testCanFailedForDeleteByNotPassingNoteId()
    {
        $input      = array(
            'isDeleted' => 1
        );
        $noteMapper = new NoteMapper();
        
        $noteModel = new NoteModel($input);
        $actualResultset = $noteMapper->delete($noteModel);
        $this->assertEquals("No query results for Note model.", $actualResultset);
    }
    
    public function testCanReadByTitle()
    {
        $input             = array(
            'id' => 2
        );
        $expectedResultset = "PHP5";
        $noteMapper        = new NoteMapper();
        $noteModel         = new NoteModel($input);
        $actualResultset   = $noteMapper->read($noteModel);
        $expectedResultset = 'PHP5';
        $this->assertEquals(2, $actualResultset->id);
        $this->assertEquals('PHP5', $actualResultset->title);
        $this->assertEquals('Server scripting language.', $actualResultset->body);
        $this->assertEquals('PHP5', $actualResultset->title);
    }
    
    public function testCanFailedByNotExistId()
    {
        $input      = array(
            'id' => 4
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $actualResultset = $noteMapper->read($noteModel);
        $this->assertEquals("No query results for Note model.", $actualResultset);
    }
}
