<?php
namespace Notes\Domain;

use Notes\Model\Note as NoteModel;
use Notes\Model\User as UserModel;

use Notes\Domain\Note as NoteDomain;

use Notes\Config\Config as Configuration;

use Notes\Model\UserTag as UserTagModel;
use Notes\Model\NoteTag as NoteTagModel;

use Notes\Collection\Collection as Collection;

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
        
        $tagsInput    = array(
            'PHP',
            'PHP6'
        );
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
        $this->assertEquals('Creating a custom exception handler is quite simple.',
            $actualResultSet[0]->getBody());

        $userModelCollection = $actualResultSet[1];
        while ($userModelCollection->hasNext()) {
            $this->assertEquals(2, $userModelCollection->getRow(0)->getId());
        $this->assertEquals(1, $userModelCollection->getRow(0)->getUserId());
        $this->assertEquals('PHP', $userModelCollection->getRow(0)->getTag());

        $this->assertEquals(3, $userModelCollection->getRow(1)->getId());
        $this->assertEquals(1, $userModelCollection->getRow(1)->getUserId());
        $this->assertEquals('PHP6', $userModelCollection->getRow(1)->getTag());
        $userModelCollection->next();
        }

        $noteTagCollection = $actualResultSet[2];
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(2, $noteTagCollection->getRow(0)->getId());
        $this->assertEquals(3, $noteTagCollection->getRow(0)->getNoteId());
        $this->assertEquals(2, $noteTagCollection->getRow(0)->getUserTagId());
        
        $this->assertEquals(3, $noteTagCollection->getRow(1)->getId());
        $this->assertEquals(3, $noteTagCollection->getRow(1)->getNoteId());
        $this->assertEquals(3, $noteTagCollection->getRow(1)->getUserTagId());
        $noteTagCollection->next();
        }
    }
    
    public function testCanCreatebyPassingEmptyArrayTag()
    {
        $noteInput    = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $UserTagModel = array();
        
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($noteModel);
        $this->assertEquals(3, $actualResultSet->getId());
        $this->assertEquals(1, $actualResultSet->getUserId());
        $this->assertEquals('Exception', $actualResultSet->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $actualResultSet->getBody());
        $this->assertEquals(0, $actualResultSet->getIsDeleted());
    }
    
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenTitileIsNull()
    {
        
        $noteInput    = array(
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $tagsInput    = array();
        $UserTagModel = array();
        
        $noteModel = new NoteModel();
        $noteModel->setBody($noteInput['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($noteModel, $tagsInput);
        
    }
    
    public function testCanDelete()
    {
        $noteInput = array(
            'id' => 1,
            'userId' => 1,
            'title' => 'PHP',
            'body' => 'Preprocessor Hypertext',
            'isDeleted' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setId($noteInput['id']);
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->update($noteModel);
        
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
        $noteInput = array(
            'userId' => 1,
            'isDeleted' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->update($noteModel);
    }
    
    public function testCanUpdate()
    {
        $input = array(
            'id' => 1,
            'userId' => 1,
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.',
            'isDeleted' => 0
        );
        
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        $noteModel->setUserId($input['userId']);
        $noteModel->setTitle($input['title']);
        $noteModel->setBody($input['body']);
        $noteModel->setIsDeleted($input['isDeleted']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->update($noteModel);
        
        $this->assertEquals(1, $actualResultSet->getId());
        $this->assertEquals('Web', $actualResultSet->getTitle());
        $this->assertEquals('PHP is a powerful tool for making dynamic Web pages.', $actualResultSet->getBody());
        
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
        
        $noteDomain           = new NoteDomain();
        $actualNoteCollection = $noteDomain->findAllNotesByUserId($noteModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteDomain_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Notes'
        ));
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
        while ($actualNoteCollection->hasNext()) {
            $this->assertEquals(1, $actualNoteCollection->getRow(0)->getId());
            $this->assertEquals(1, $actualNoteCollection->getRow(0)->getUserId());
            $this->assertEquals('PHP', $actualNoteCollection->getRow(0)->getTitle());
            $this->assertEquals('Preprocessor Hypertext', $actualNoteCollection->getRow(0)->getBody());
            
            $this->assertEquals(2, $actualNoteCollection->getRow(1)->getId());
            $this->assertEquals(1, $actualNoteCollection->getRow(1)->getUserId());
            $this->assertEquals('PHP5', $actualNoteCollection->getRow(1)->getTitle());
            $this->assertEquals('Server scripting language.', $actualNoteCollection->getRow(1)->getBody());
            $actualNoteCollection->next();
        }
    }
    
    public function testReadByNoteId()
    {
        $input     = array(
            'id' => 1
        );
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain           = new NoteDomain();

        $noteModel   = $noteDomain->read($noteModel);

        $this->assertEquals(1, $noteModel[0]['id']);
        $this->assertEquals(1, $noteModel[0]['userId']);
        $this->assertEquals('PHP', $noteModel[0]['title']);
        $this->assertEquals('Preprocessor Hypertext', $noteModel[0]['body']);
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
        $actualResultSet = $noteDomain->read($noteModel);
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
        $actualResultSet = $noteDomain->read($noteModel);
    }
}
