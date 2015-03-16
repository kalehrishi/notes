<?php

namespace Notes\Domain;

use Notes\Mapper\NoteTag as NoteTagMapper;

use Notes\Model\NoteTag as NoteTagModel;

use Notes\Model\UserTag as UserTagModel;
use Notes\Model\Note as NoteModel;

use Notes\Config\Config as Configuration;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

class NoteTagTest extends \PHPUnit_Extensions_Database_TestCase
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
            $this->connection->exec("set foreign_key_checks=0");
            return $this->createDefaultDBConnection($this->connection, $dbName);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
    public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/noteTagDomain_seed.xml');
    }
    
    public function testCanCreateNewUserTagWithExistingNote()
    {
        $input     = array(
            'noteId' => 3,
            'userId' => 1,
            'userTag' => 'Mysql'
        );
        $noteModel = new NoteModel();
        $noteModel->setId($input['noteId']);
        $noteModel->setUserId($input['userId']);
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTag($input['userTag']);
        
        $noteTagDomain               = new NoteTag();
        $noteTagAndUserTagCollection = $noteTagDomain->edit($noteModel, $noteTagModel);
        $userTagsCollection          = $noteTagAndUserTagCollection[0];
        
        while ($userTagsCollection->hasNext()) {
            $this->assertEquals(4, $userTagsCollection->getRow(0)->getId());
            $this->assertEquals(1, $userTagsCollection->getRow(0)->getUserId());
            $this->assertEquals('Mysql', $userTagsCollection->getRow(0)->getTag());
            
            $userTagsCollection->next();
        }
        
        $noteTagsCollection = $noteTagAndUserTagCollection[1];
        while ($noteTagsCollection->hasNext()) {
            $this->assertEquals(4, $noteTagsCollection->getRow(0)->getId());
            $this->assertEquals(3, $noteTagsCollection->getRow(0)->getNoteId());
            $this->assertEquals(4, $noteTagsCollection->getRow(0)->getUserTagId());
            
            $noteTagsCollection->next();
        }
        
    }
    public function testCanCreateNoteTag()
    {
        $input = array(
            'noteId' => 3,
            'userId' => 1,
            'userTag' => 'WordPress',
            'isDeleted' => 0
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $userTagModel = new UserTagModel();
        $userTagModel->setTag($input['userTag']);
        $userTagModel->setUserId($input['userId']);
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->create($noteTagModel, $userTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTagDomain_after_create.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        $this->assertEquals(4, $noteTagModel->getId());
        $this->assertEquals(3, $noteTagModel->getNoteId());
        $this->assertEquals(4, $noteTagModel->getUserTagId());
        $this->assertEquals(0, $noteTagModel->getIsDeleted());
        $this->assertEquals('WordPress', $noteTagModel->getUserTag());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenUserTagIdIsNull()
    {
        $input = array(
            'noteId' => 1,
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        
        $userTagModel = new UserTagModel();
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->create($noteTagModel, $userTagModel);
    }
    public function testCanReadNoteTagByNoteId()
    {
        $input = array(
            'noteid' => 2
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteid']);
        
        
        $noteTagDomain     = new NoteTag();
        $noteTagCollection = $noteTagDomain->readAllTag($noteTagModel);
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTagDomain_read.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(3, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(2, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(3, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getIsDeleted());
            $noteTagCollection->next();
        }
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    /**
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage  Can Not Found Given Model In Database
     */
    public function testThrowsExceptionWhenNoteTagIdDoesNotExist()
    {
        $input = array(
            'noteid' => 54
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteid']);
        
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->readAllTag($noteTagModel);
    }
    public function testCanDeleteNoteTag()
    {
        $input = array(
            'id' => 3,
            'noteId' => 2,
            'userTagId' => 3,
            'isDeleted' => 0
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setId($input['id']);
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setUserTagId($input['userTagId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->update($noteTagModel);
        
        
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/noteTagDomain_after_delete.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'NoteTags'
        ));
        
        $this->assertEquals(3, $noteTagModel->getId());
        $this->assertEquals(2, $noteTagModel->getNoteId());
        $this->assertEquals(3, $noteTagModel->getUserTagId());
        $this->assertEquals(1, $noteTagModel->getIsDeleted());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenNoteTagIdIsNull()
    {
        $input = array(
            'noteId' => 2,
            'userTagId' => 3,
            'isDeleted' => 0
        );
        
        $noteTagModel = new NoteTagModel();
        $noteTagModel->setNoteId($input['noteId']);
        $noteTagModel->setIsDeleted($input['isDeleted']);
        
        $noteTagDomain = new NoteTag();
        $noteTagModel  = $noteTagDomain->update($noteTagModel);
    }
}
