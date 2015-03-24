<?php
namespace Notes\Domain;

use Notes\Model\Note as NoteModel;
use Notes\Model\User as UserModel;

use Notes\Domain\Note as NoteDomain;

use Notes\Config\Config as Configuration;

use Notes\Collection\Collection as Collection;
use Notes\Collection\UserTagCollection as UserTagCollection;
use Notes\Collection\NoteTagCollection as NoteTagCollection;

use Notes\Domain\UserTag as UserTagDomain;
use Notes\Model\UserTag as UserTagModel;

use Notes\Domain\NoteTag as NoteTagDomain;
use Notes\Model\NoteTag as NoteTagModel;

use Notes\Domain\User as UserDomain;

class NoteTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/domain_note_seed.xml');
    }
    
    public function testCanCreate()
    {
        $noteInput = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteTag = array(
            '0'=>array(
                'id' => 1,
                'noteId' => 3,
                'userTagId' => 1,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 1,
                    'userId' => 1,
                    'tag' => 'OOP PHP',
                    'isDeleted' => 0)
              ),
            '1'=>array(
                'id' => 2,
                'noteId' => 3,
                'userTagId' => 3,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 2,
                    'userId' => 1,
                    'tag' => 'First Tag',
                    'isDeleted' => 0)
              ),
            '2'=>array(
                'id' => 2,
                'noteId' => 3,
                'userTagId' => 4,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 3,
                    'userId' => 1,
                    'tag' => 'Second Tag',
                    'isDeleted' => 0)
              )
            );
        $noteTagCollection = new NoteTagCollection($noteTag);
        
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $noteModel->setNoteTag($noteTagCollection);
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->create($noteModel);
        
        $this->assertEquals(3, $noteModel->getId());
        $this->assertEquals(1, $noteModel->getUserId());
        $this->assertEquals('Exception', $noteModel->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $noteModel->getBody());
        
        $noteTagCollection = $noteModel->getNoteTag();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(3, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(3, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTagId());

            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getUserId());
            $this->assertEquals('OOP PHP', $noteTagCollection->getRow(0)->getUserTag()->getTag());

            $this->assertEquals(4, $noteTagCollection->getRow(1)->getId());
            $this->assertEquals(3, $noteTagCollection->getRow(1)->getNoteId());
            $this->assertEquals(3, $noteTagCollection->getRow(1)->getUserTagId());

            $this->assertEquals(3, $noteTagCollection->getRow(1)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(1)->getUserTag()->getUserId());
            $this->assertEquals('First Tag', $noteTagCollection->getRow(1)->getUserTag()->getTag());
            
            $this->assertEquals(5, $noteTagCollection->getRow(2)->getId());
            $this->assertEquals(3, $noteTagCollection->getRow(2)->getNoteId());
            $this->assertEquals(4, $noteTagCollection->getRow(2)->getUserTagId());

            $this->assertEquals(4, $noteTagCollection->getRow(2)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(2)->getUserTag()->getUserId());
            $this->assertEquals('Second Tag', $noteTagCollection->getRow(2)->getUserTag()->getTag());
            $noteTagCollection->next();
        }
        
    }
    
    public function testCanReadByNoteId()
    {
        $input = array(
            'id' => 1
        );
        
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->read($noteModel);
        
        $this->assertEquals(1, $noteModel->getId());
        $this->assertEquals(1, $noteModel->getUserId());
        $this->assertEquals('PHP', $noteModel->getTitle());
        $this->assertEquals('Preprocessor Hypertext', $noteModel->getBody());
        
        $noteTagCollection = $noteModel->getNoteTag();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(2, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(2, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getIsDeleted());

            $this->assertEquals(2, $noteTagCollection->getRow(0)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getUserId());
            $this->assertEquals('Javascript', $noteTagCollection->getRow(0)->getUserTag()->getTag());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getUserTag()->getIsDeleted());

            $noteTagCollection->next();
        }
    }
    
    public function testCanReadAllNotesByUserId()
    {
        $input = array(
            'id' => 1
        );
        
        $userModel = new UserModel();
        $userModel->setId($input['id']);
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->findAllNotesByUserId($userModel);
        
        while ($noteModel->hasNext()) {
            $this->assertEquals(1, $noteModel->getRow(0)->getId());
            $this->assertEquals(1, $noteModel->getRow(0)->getUserId());
            $this->assertEquals('PHP', $noteModel->getRow(0)->getTitle());
            $this->assertEquals('Preprocessor Hypertext', $noteModel->getRow(0)->getBody());

            $this->assertEquals(2, $noteModel->getRow(1)->getId());
            $this->assertEquals(1, $noteModel->getRow(1)->getUserId());
            $this->assertEquals('PHP5', $noteModel->getRow(1)->getTitle());
            $this->assertEquals('Server scripting language.', $noteModel->getRow(1)->getBody());
            $noteModel->next();
        }
    }
    
    public function testCanUpdate()
    {
        $noteInput = array(
            'id' => 1,
            'userId' => 1,
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.',
            'isDeleted' => 0
        );
        $noteTag  = array(
            0 => array(
                'id' => 1,
                'noteId' => 1,
                'userTagId' => 1,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 1,
                    'userId' => 1,
                    'tag' => 'OOP PHP',
                    'isDeleted' => 1
                )
            ),

            1 => array
            ('id' => 2,
                'noteId' => 1,
                'userTagId' => 2,
                'isDeleted' => 0,
                'userTag' => array(
                'id' => 2,
                'userId' => 1,
                'tag' => 'PDOException',
                'isDeleted' => 0
                )
            ),
            
            
            2 => array(
                'id' => 3,
                'noteId' => 1,
                'userTagId' => 3,
                'isDeleted' => 0,
                'userTag' => array(
                    'id' => 3,
                    'userId' => 1,
                    'tag' => 'Runtime',
                    'isDeleted' => 0
               )
            )
        );
        $noteTagCollection = new NoteTagCollection($noteTag);
        
        $noteModel = new NoteModel();
        $noteModel->setId($noteInput['id']);
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
        
        $noteModel->setNoteTag($noteTagCollection);
        
        
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->update($noteModel);
        
        $this->assertEquals(1, $noteModel->getId());
        $this->assertEquals(1, $noteModel->getUserId());
        $this->assertEquals('Web', $noteModel->getTitle());
        $this->assertEquals('PHP is a powerful tool for making dynamic Web pages.', $noteModel->getBody());
        
        $noteTagCollection = $noteModel->getNoteTag();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getIsDeleted());
            $this->assertEquals('OOP PHP', $noteTagCollection->getRow(0)->getUserTag()->getTag());
            
            $this->assertEquals(3, $noteTagCollection->getRow(1)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(1)->getNoteId());
            $this->assertEquals(3, $noteTagCollection->getRow(1)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(1)->getIsDeleted());
            $this->assertEquals('PDOException', $noteTagCollection->getRow(1)->getUserTag()->getTag());
            
            $this->assertEquals(4, $noteTagCollection->getRow(2)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(2)->getNoteId());
            $this->assertEquals(4, $noteTagCollection->getRow(2)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(2)->getIsDeleted());
            $this->assertEquals('Runtime', $noteTagCollection->getRow(2)->getUserTag()->getTag());
            $noteTagCollection->next();
        }
        
    }
}
