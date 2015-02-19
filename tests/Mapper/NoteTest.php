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
        $noteMapper->update($noteModel);
        $query             = "select id, title, body from Notes";
        $actualResultset   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedResultset = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_update.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedResultset, $actualResultset);
    }
    
    /**
     * @expectedException PDOException
     * @expectedMessage Note Id Parameter Missing
     */
    public function testCanFailedToUpdateByNotPassingNoteId()
    {
        
        $input      = array(
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $noteMapper->update($noteModel);
        
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
        $noteMapper->create($noteModel);
        
        $query             = "select id, userId, title, body,isDeleted from Notes";
        $actualResultset   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedResultset = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_insert.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedResultset, $actualResultset);
    }
    
    /**
     * @expectedException PDOException
     * @expectedMessage Parameter Missing
     */
    public function testCanFailedForAddEntry()
    {
        $input      = array(
            'userId' => 1,
            'body' => 'Insert Data Into MySQL Using PDO'
        );
        $noteMapper = new NoteMapper();
        
        $noteModel = new NoteModel($input);
        $noteMapper->create($noteModel);
    }
    
    public function testDeleteEntry()
    {
        $input      = array(
            'id' => 2,
            'isDeleted' => 1
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $noteMapper->delete($noteModel);
        $query             = "select id, userId, title, body,isDeleted from Notes";
        $actualResultset   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedResultset = $this->createXMLDataSet(dirname(__FILE__) . '/_files/note_after_delete.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedResultset, $actualResultset);
    }
    
    /**
     * @expectedException PDOException
     * @expectedMessage Note Id Parameter Missing For Delete
     */
    public function testCanFailedForDeleteByNotPassingNoteId()
    {
        $input      = array(
            'isDeleted' => 1
        );
        $noteMapper = new NoteMapper();
        
        $noteModel = new NoteModel($input);
        $noteMapper->delete($noteModel);
    }
    
    public function testCanReadByTitle()
    {
        $input             = array(
            'id' => 2
        );
        $expectedResultset = array(
            0 => array(
                'id' => 2,
                'title' => 'PHP5',
                'body' => 'Server scripting language.'
            )
        );
        $noteMapper        = new NoteMapper();
        $noteModel         = new NoteModel($input);
        $actualResultset   = $noteMapper->read($noteModel);
        $this->assertEquals($expectedResultset, $actualResultset);
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage   Object does not exist, cannot read
     */
    public function testCanFailedByNotExistId()
    {
        $input      = array(
            'id' => 4
        );
        $noteMapper = new NoteMapper();
        $noteModel  = new NoteModel($input);
        $noteMapper->read($noteModel);
    }
}
