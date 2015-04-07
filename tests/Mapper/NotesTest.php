<?php
namespace Notes;

use Notes\Mapper\Notes as NotesMapper;
use Notes\Model\Note as NoteModel;
use Notes\Config\Config as Configuration;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class NotesTest extends \PHPUnit_Extensions_Database_TestCase
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
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
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
    
    
    public function testReadAllNotesByUserId()
    {
        $input     = array(
            'userId' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setUserId($input['userId']);
        
        $notesMapper           = new NotesMapper();
        $actualNotesCollection = $notesMapper->findAllNotesByUserId($noteModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteMapper_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Notes'
        ));
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
        while ($actualNotesCollection->hasNext()) {
            $this->assertEquals(1, $actualNotesCollection->getRow(0)->getId());
            $this->assertEquals(1, $actualNotesCollection->getRow(0)->getUserId());
            $this->assertEquals('PHP', $actualNotesCollection->getRow(0)->getTitle());
            $this->assertEquals('Preprocessor Hypertext', $actualNotesCollection->getRow(0)->getBody());
            
            $this->assertEquals(2, $actualNotesCollection->getRow(1)->getId());
            $this->assertEquals(1, $actualNotesCollection->getRow(1)->getUserId());
            $this->assertEquals('PHP5', $actualNotesCollection->getRow(1)->getTitle());
            $this->assertEquals('Server scripting language.', $actualNotesCollection->getRow(1)->getBody());
            $actualNotesCollection->next();
        }
    }
}
