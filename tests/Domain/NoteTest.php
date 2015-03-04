<?php
namespace Notes\Domain;

use Notes\Model\Note as NoteModel;
use Notes\Domain\Note as NoteDomain;
use Notes\Config\Config as Configuration;
use Notes\Model\UserTag as UserTagModel;
use Notes\Model\NoteTag as NoteTagModel;
use Notes\Model\User as UserModel;

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

        $tagsInput = array('PHP', 'PHP6');
        $UserTagModel = array();

        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($noteModel, $tagsInput);
        
        $this->assertEquals(3, $actualResultSet[0]->getId());
        $this->assertEquals(1, $actualResultSet[0]->getUserId());
        $this->assertEquals('Exception', $actualResultSet[0]->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $actualResultSet[0]->getBody());
        $this->assertEquals(0, $actualResultSet[0]->getIsDeleted());
        
        $this->assertEquals(2, $actualResultSet[1][0]->getId());
        $this->assertEquals(1, $actualResultSet[1][0]->getUserId());
        $this->assertEquals('PHP', $actualResultSet[1][0]->getTag());
        
        $this->assertEquals(3, $actualResultSet[1][1]->getId());
        $this->assertEquals(1, $actualResultSet[1][1]->getUserId());
        $this->assertEquals('PHP6', $actualResultSet[1][1]->getTag());
        $this->assertEquals(2, $actualResultSet[2][0]->getId());
        $this->assertEquals(3, $actualResultSet[2][0]->getNoteId());
        $this->assertEquals(2, $actualResultSet[2][0]->getUserTagId());
        $this->assertEquals(3, $actualResultSet[2][1]->getId());
        $this->assertEquals(3, $actualResultSet[2][1]->getNoteId());
        $this->assertEquals(3, $actualResultSet[2][1]->getUserTagId());

        
        
    }
    
    public function testCanCreatebyPassingEmptyArrayTag()
    {
        $noteInput = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $tagsInput = array('JavaScript Exception');
        $UserTagModel = array();

        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($noteModel, $tagsInput);
        
        $this->assertEquals(3, $actualResultSet[0]->getId());
        $this->assertEquals(1, $actualResultSet[0]->getUserId());
        $this->assertEquals('Exception', $actualResultSet[0]->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $actualResultSet[0]->getBody());
        $this->assertEquals(0, $actualResultSet[0]->getIsDeleted());
    }

    /**
    * @expectedException         InvalidArgumentException
    * @expectedExceptionMessage  Input should not be null
    */
    public function testThrowsExceptionWhenTitileIsNull()
    {

        $noteInput = array(
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $tagsInput = array();
        $UserTagModel = array();

        $noteModel = new NoteModel();
        $noteModel->setBody($noteInput['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($noteModel, $tagsInput);
        
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
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->delete($noteModel);
        
        $this->assertEquals(1, $actualResultSet->getId());
        $this->assertEquals(1, $actualResultSet->getUserId());
        $this->assertEquals(1, $actualResultSet->getIsDeleted());
        
    }
    
    /**
    * @expectedException         InvalidArgumentException
    * @expectedExceptionMessage  Input should not be null
    */
    public function testThrowsExceptionWhenNoteIdIsNotPass()
    {
        $noteInput     = array(
            'userId' => 1,
            'isDeleted' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->delete($noteModel);
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
    
    /**
    * @expectedException         InvalidArgumentException
    * @expectedExceptionMessage  Input should not be null
    */
    public function testThrowsInvalidArgumentExceptionWhenNoteIdIsNotPass()
    {
        $input = array(
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.'
        );
        
        $noteModel = new NoteModel();
        $noteModel->setTitle($input['title']);
        $noteModel->setBody($input['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->update($noteModel);
    }
    public function testReadByUserId()
    {
        $input     = array(
            'userId' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setUserId($input['userId']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->readAllNotes($noteModel);
        
        $this->assertEquals(1, $actualResultSet[0]['id']);
        $this->assertEquals(1, $actualResultSet[0]['userId']);
        $this->assertEquals('PHP', $actualResultSet[0]['title']);
        $this->assertEquals('Preprocessor Hypertext', $actualResultSet[0]['body']);

        $this->assertEquals(2, $actualResultSet[1]['id']);
        $this->assertEquals(1, $actualResultSet[1]['userId']);
        $this->assertEquals('PHP5', $actualResultSet[1]['title']);
        $this->assertEquals('Server scripting language.', $actualResultSet[1]['body']);
    }

    public function testReadByNoteId()
    {
        $input     = array(
            'id' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->readNote($noteModel);
        $this->assertEquals(1, $actualResultSet[0]['id']);
        $this->assertEquals('PHP', $actualResultSet[0]['title']);
        $this->assertEquals('Preprocessor Hypertext', $actualResultSet[0]['body']);
    }

    /**
    * @expectedException         InvalidArgumentException
    * @expectedExceptionMessage  Input should not be null
    */
    public function testThrowsExceptionWhenNoteIdIsNull()
    {
        $input     = array(
            'id' => null
            );
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->readNote($noteModel);
    }

    /**
     * @expectedException        Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    public function testThrowsModelNotFoundExceptionWhenNoteIdNotExist()
    {
        $input     = array(
            'id' => 10
            );
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->readNote($noteModel);
    }
}
