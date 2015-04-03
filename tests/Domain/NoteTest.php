<?php
namespace Notes\Domain;

use Notes\Model\Note as NoteModel;
use Notes\Model\User as UserModel;

use Notes\Model\NoteTag as NoteTagModel;
use Notes\Model\UserTag as UserTagModel;

use Notes\Config\Config as Configuration;

use Notes\Collection\Collection as Collection;
use Notes\Collection\NoteTagCollection as NoteTagCollection;

use Notes\Domain\Note as NoteDomain;
use Notes\Domain\User as UserDomain;

use Notes\Domain\UserTag as UserTagDomain;
use Notes\Domain\NoteTag as NoteTagDomain;

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
    
    
    public function testCouldBeReadAllNotesByUserId()
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
            $this->assertEquals('RSYNC', $noteModel->getRow(0)->getTitle());
            $firstBodyText = 'To use sync a folder to the guest machine.';
            $this->assertEquals($firstBodyText, $noteModel->getRow(0)->getBody());
            
            $this->assertEquals(2, $noteModel->getRow(1)->getId());
            $this->assertEquals(1, $noteModel->getRow(1)->getUserId());
            $this->assertEquals('NFS', $noteModel->getRow(1)->getTitle());
            $secondBodyText = 'NFS folders do not work on Windows hosts.';
            $this->assertEquals($secondBodyText, $noteModel->getRow(1)->getBody());
            
            $this->assertEquals(3, $noteModel->getRow(2)->getId());
            $this->assertEquals(1, $noteModel->getRow(2)->getUserId());
            $this->assertEquals('HTML', $noteModel->getRow(2)->getTitle());
            $thirdBodyText = 'HyperText Markup Language';
            $this->assertEquals($thirdBodyText, $noteModel->getRow(2)->getBody());
            
            $noteModel->next();
        }
    }
    
    
    /**
     * @expectedException         InvalidArgumentException
     * @expectedExceptionMessage  Input should not be null
     */
    public function testThrowsExceptionWhenNoteIdIsNotPass()
    {
        $noteModel = new NoteModel();
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->read($noteModel);
    }
    
    public function testCouldBeReadByNoteId()
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
        $this->assertEquals('RSYNC', $noteModel->getTitle());
        $this->assertEquals('To use sync a folder to the guest machine.', $noteModel->getBody());
        
        $noteTagCollection = $noteModel->getNoteTags();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getIsDeleted());
            
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getUserId());
            $this->assertEquals('RSYNC1', $noteTagCollection->getRow(0)->getUserTag()->getTag());
            $this->assertEquals(0, $noteTagCollection->getRow(0)->getUserTag()->getIsDeleted());
            $noteTagCollection->next();
        }
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
    public function testCouldBeCreateWithoutPassingTag()
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
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->create($noteModel);
        $this->assertEquals(6, $noteModel->getId());
        $this->assertEquals(1, $noteModel->getUserId());
        $this->assertEquals('Exception', $noteModel->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $noteModel->getBody());
    }
    
    public function testCouldBeCreateHavingExistingTag()
    {
        $noteInput         = array(
            'userId' => 1,
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteTags           = array(
            '0' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => null,
                    'userId' => 1,
                    'tag' => 'OOP PHP',
                    'isDeleted' => null
                )
            ),
            '1' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => 4,
                    'userId' => 2,
                    'tag' => 'Javascript',
                    'isDeleted' => 0
                )
            ),
            '2' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => null,
                    'userId' => 1,
                    'tag' => 'Second Tag',
                    'isDeleted' => null
                )
            ),
            '3' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => 3,
                    'userId' => 1,
                    'tag' => 'HTML5',
                    'isDeleted' => 0
                )
            )
        );
        $noteTagCollection = new NoteTagCollection($noteTags);
        
        
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        $noteModel->setNoteTags($noteTagCollection);
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->create($noteModel);
        
        $this->assertEquals(6, $noteModel->getId());
        $this->assertEquals(1, $noteModel->getUserId());
        $this->assertEquals('Exception', $noteModel->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $noteModel->getBody());
        
        $noteTagCollection = $noteModel->getNoteTags();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(7, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(6, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(6, $noteTagCollection->getRow(0)->getUserTagId());
            
            $this->assertEquals(6, $noteTagCollection->getRow(0)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getUserId());
            $this->assertEquals('OOP PHP', $noteTagCollection->getRow(0)->getUserTag()->getTag());
            
            $this->assertEquals(8, $noteTagCollection->getRow(1)->getId());
            $this->assertEquals(6, $noteTagCollection->getRow(1)->getNoteId());
            $this->assertEquals(4, $noteTagCollection->getRow(1)->getUserTagId());
            
            $this->assertEquals(4, $noteTagCollection->getRow(1)->getUserTag()->getId());
            $this->assertEquals(2, $noteTagCollection->getRow(1)->getUserTag()->getUserId());
            $this->assertEquals('Javascript', $noteTagCollection->getRow(1)->getUserTag()->getTag());
            
            $this->assertEquals(9, $noteTagCollection->getRow(2)->getId());
            $this->assertEquals(6, $noteTagCollection->getRow(2)->getNoteId());
            $this->assertEquals(7, $noteTagCollection->getRow(2)->getUserTagId());
            
            $this->assertEquals(7, $noteTagCollection->getRow(2)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(2)->getUserTag()->getUserId());
            $this->assertEquals('Second Tag', $noteTagCollection->getRow(2)->getUserTag()->getTag());
            
            $this->assertEquals(10, $noteTagCollection->getRow(3)->getId());
            $this->assertEquals(6, $noteTagCollection->getRow(3)->getNoteId());
            $this->assertEquals(3, $noteTagCollection->getRow(3)->getUserTagId());
            
            $this->assertEquals(3, $noteTagCollection->getRow(3)->getUserTag()->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(3)->getUserTag()->getUserId());
            $this->assertEquals('HTML5', $noteTagCollection->getRow(3)->getUserTag()->getTag());
            
            $noteTagCollection->next();
        }
    }
    public function testCouldBeCreateWithoutHavingExistingTag()
    {
        $noteInput         = array(
            'userId' => 3,
            'title' => 'Explode',
            'body' => 'Break String into delimeter chunks.'
        );
        $noteTags           = array(
            '0' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => null,
                    'userId' => 3,
                    'tag' => 'implode',
                    'isDeleted' => null
                )
            )
        );
        $noteTagCollection = new NoteTagCollection($noteTags);
        
        
        $noteModel = new NoteModel();
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        $noteModel->setNoteTags($noteTagCollection);
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->create($noteModel);
        
        $this->assertEquals(6, $noteModel->getId());
        $this->assertEquals(3, $noteModel->getUserId());
        $this->assertEquals('Explode', $noteModel->getTitle());
        $this->assertEquals('Break String into delimeter chunks.', $noteModel->getBody());
        
        $noteTagCollection = $noteModel->getNoteTags();
        while ($noteTagCollection->hasNext()) {
            $this->assertEquals(7, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(6, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(6, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals('implode', $noteTagCollection->getRow(0)->getUserTag()->getTag());
            $noteTagCollection->next();
        }
    }
    
    public function testCanUpdate()
    {
        $noteInput         = array(
            'id' => 1,
            'userId' => 1,
            'title' => 'Web',
            'body' => 'PHP is a powerful tool for making dynamic Web pages.',
            'isDeleted' => 0
        );
        $noteTags           = array(
            '0' => array(
                'id' => 1,
                'noteId' => 1,
                'userTagId' => 1,
                'isDeleted' => 1,
                'userTag' => array(
                    'id' => 1,
                    'userId' => 1,
                    'tag' => 'RSYNC1',
                    'isDeleted' => 0
                )
            ),
            '1' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => null,
                    'userId' => 1,
                    'tag' => 'PHP5',
                    'isDeleted' => null
                )
            ),
            '2' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => null,
                    'userId' => 1,
                    'tag' => 'WordPress',
                    'isDeleted' => null
                )
            ),
            '3' => array(
                'id' => null,
                'noteId' => null,
                'userTagId' => null,
                'isDeleted' => null,
                'userTag' => array(
                    'id' => 4,
                    'userId' => 2,
                    'tag' => 'Javascript',
                    'isDeleted' => 0
                )
            )
        );
        $noteTagCollection = new NoteTagCollection($noteTags);
        
        $noteModel = new NoteModel();
        $noteModel->setId($noteInput['id']);
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
        $noteModel->setNoteTags($noteTagCollection);
        
        $noteDomain = new NoteDomain();
        $noteModel  = $noteDomain->update($noteModel);
        
        $this->assertEquals(1, $noteModel->getId());
        $this->assertEquals(1, $noteModel->getUserId());
        $this->assertEquals('Web', $noteModel->getTitle());
        $this->assertEquals('PHP is a powerful tool for making dynamic Web pages.', $noteModel->getBody());
        
        
        $noteTagCollection = $noteModel->getNoteTags();
        while ($noteTagCollection->hasNext()) {
            
            
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getNoteId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTagId());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getIsDeleted());
            $this->assertEquals('RSYNC1', $noteTagCollection->getRow(0)->getUserTag()->getTag());
            $this->assertEquals(1, $noteTagCollection->getRow(0)->getUserTag()->getUserId());
            
            $this->assertEquals(7, $noteTagCollection->getRow(1)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(1)->getNoteId());
            $this->assertEquals(6, $noteTagCollection->getRow(1)->getUserTagId());
            $this->assertEquals('PHP5', $noteTagCollection->getRow(1)->getUserTag()->getTag());
            $this->assertEquals(1, $noteTagCollection->getRow(1)->getUserTag()->getUserId());
            
            $this->assertEquals(8, $noteTagCollection->getRow(2)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(2)->getNoteId());
            $this->assertEquals(7, $noteTagCollection->getRow(2)->getUserTagId());
            $this->assertEquals('WordPress', $noteTagCollection->getRow(2)->getUserTag()->getTag());
            $this->assertEquals(1, $noteTagCollection->getRow(2)->getUserTag()->getUserId());

            $this->assertEquals(9, $noteTagCollection->getRow(3)->getId());
            $this->assertEquals(1, $noteTagCollection->getRow(3)->getNoteId());
            $this->assertEquals(4, $noteTagCollection->getRow(3)->getUserTagId());
            $this->assertEquals('Javascript', $noteTagCollection->getRow(3)->getUserTag()->getTag());
            $this->assertEquals(2, $noteTagCollection->getRow(3)->getUserTag()->getUserId());
            $noteTagCollection->next();
        }
    }
    
    /*public function testCanDelete()
    {
        $noteInput         = array(
            'id' => 4,
            'userId' => 2,
            'title' => 'Ajax',
            'body' => 'Asynchronous JavaScript and XML',
            'isDeleted' => 1
        );
        
        $noteModel = new NoteModel();
        
        $noteModel->setId($noteInput['id']);
        $noteModel->setUserId($noteInput['userId']);
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        $noteModel->setIsDeleted($noteInput['isDeleted']);
       
        $noteDomain = new NoteDomain();
        
        $noteModel = $noteDomain->update($noteModel);
        
        $this->assertEquals(4, $noteModel->getId());
        $this->assertEquals(2, $noteModel->getUserId());
        $this->assertEquals('Ajax', $noteModel->getTitle());
        $this->assertEquals('Asynchronous JavaScript and XML', $noteModel->getBody());
        $this->assertEquals(1, $noteModel->getIsDeleted());
    }*/
}
