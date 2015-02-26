<?php
namespace Notes\Domain;

use Notes\Model\Note as NoteModel;
use Notes\Domain\Note as NoteDomain;
use Notes\Config\Config as Configuration;
use Notes\Model\UserTag as UserTagModel;
use Notes\Model\NoteTag as NoteTagModel;

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
    
    public function testCanCreate()
    {
        $noteInput = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $usetTagInput = array(
            'userId' => 1,
            'tag' => 'PHP'
        );
        
        $userTagModel = new UserTagModel();
        $userTagModel->setUserId($usetTagInput['userId']);
        $userTagModel->setTag($usetTagInput['tag']);
        
        $noteTagInput = array(
            'noteId' => 2,
            'userTagId' => 1
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($noteTagInput['noteId']);
        $noteTagModel->setUserTagId($noteTagInput['userTagId']);
        

        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($noteModel, $userTagModel, $noteTagModel);
        $this->assertEquals(3, $actualResultSet[0]->getId());
        $this->assertEquals(1, $actualResultSet[0]->getUserId());
        $this->assertEquals('Exception', $actualResultSet[0]->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $actualResultSet[0]->getBody());
        $this->assertEquals(0, $actualResultSet[0]->getIsDeleted());
        
        $this->assertEquals(2, $actualResultSet[1]->getId());
        $this->assertEquals(1, $actualResultSet[1]->getUserId());
        $this->assertEquals('PHP', $actualResultSet[1]->getTag());
        $this->assertEquals(0, $actualResultSet[1]->getIsDeleted());

        $this->assertEquals(2, $actualResultSet[2]->getId());
        $this->assertEquals(2, $actualResultSet[2]->getNoteId());
        $this->assertEquals(1, $actualResultSet[2]->getUserTagId());
        
    }
    
    public function testCanDelete()
    {
        $noteInput     = array(
            'id' => 1,
            'userId' => 1,
            'isDeleted' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setId($noteInput['id']);
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
        
        $noteTagInput = array(
            'id' => 1,
            'noteId' => 1,
            'userTagId' => 1
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($noteTagInput['id']);
        $noteTagModel->setNoteId($noteTagInput['noteId']);
        $noteTagModel->setUserTagId($noteTagInput['userTagId']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->delete($noteModel, $noteTagModel);
        
        $this->assertEquals(1, $actualResultSet[0]->getId());
        $this->assertEquals(1, $actualResultSet[0]->getUserId());
        $this->assertEquals(1, $actualResultSet[0]->getIsDeleted());
        
        $this->assertEquals(1, $actualResultSet[1]->getId());
        $this->assertEquals(1, $actualResultSet[1]->getNoteId());
        $this->assertEquals(1, $actualResultSet[1]->getUserTagId());
        $this->assertEquals(1, $actualResultSet[1]->getIsDeleted());
        
    }
    
    public function testCanUpdate()
    {
        $input = array(
            'id' => 1,
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        $noteModel->setTitle($input['title']);
        $noteModel->setBody($input['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->update($noteModel);
        
        $this->assertEquals("Updated Successfully", $actualResultSet);
        $query           = "select id, title, body from Notes";
        $actualDataSet   = $this->getConnection()->createQueryTable('Notes', $query);
        $expectedDataSet = $this->createXMLDataSet(dirname(__FILE__) . '/_files/domain_note_after_update.xml')
        ->getTable("Notes");
        $this->assertTablesEqual($expectedDataSet, $actualDataSet);
        
    }
    
    public function testReadById()
    {
        $input     = array(
            'id' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->read($noteModel);
        
        $this->assertEquals(1, $actualResultSet->getId());
        $this->assertEquals('PHP', $actualResultSet->getTitle());
        $this->assertEquals('Preprocessor Hypertext', $actualResultSet->getBody());
    }
}
