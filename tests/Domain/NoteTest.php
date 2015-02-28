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
        $userInput = array(
            'firstName' => 'anusha',
            'lastName' => 'hiremath',
            'email' => 'anusha@gmail.com',
            'password' => 'Sfh@sk1223',
            'createdOn' => '2014-10-31 20:59:59'
            );
        $userModel = new userModel();
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        $userModel->setCreatedOn($userInput['createdOn']);

        $noteInput = array(
            'title' => 'Exception',
            'body' => 'Creating a custom exception handler is quite simple.'
        );
        $noteModel = new NoteModel();
        $noteModel->setTitle($noteInput['title']);
        $noteModel->setBody($noteInput['body']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->create($userModel, $noteModel);
        
        $this->assertEquals(3, $actualResultSet[0]->getId());
        $this->assertEquals(2, $actualResultSet[0]->getUserId());
        $this->assertEquals('Exception', $actualResultSet[0]->getTitle());
        $this->assertEquals('Creating a custom exception handler is quite simple.', $actualResultSet[0]->getBody());
        $this->assertEquals(0, $actualResultSet[0]->getIsDeleted());
        
        $this->assertEquals(2, $actualResultSet[1][0]->getId());
        $this->assertEquals(2, $actualResultSet[1][0]->getUserId());
        $this->assertEquals('PHP', $actualResultSet[1][0]->getTag());
        
        $this->assertEquals(3, $actualResultSet[1][1]->getId());
        $this->assertEquals(2, $actualResultSet[1][1]->getUserId());
        $this->assertEquals('PHP6', $actualResultSet[1][1]->getTag());

        $this->assertEquals(2, $actualResultSet[2][0]->getId());
        $this->assertEquals(3, $actualResultSet[2][0]->getNoteId());
        $this->assertEquals(2, $actualResultSet[2][0]->getUserTagId());

        $this->assertEquals(3, $actualResultSet[2][1]->getId());
        $this->assertEquals(3, $actualResultSet[2][1]->getNoteId());
        $this->assertEquals(3, $actualResultSet[2][1]->getUserTagId());
        
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
    
    public function testReadByUserId()
    {
        $input     = array(
            'userId' => 1
        );
        $flag =1;
        $noteModel = new NoteModel();
        $noteModel->setUserId($input['userId']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->read($noteModel, $flag);
        
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
        $flag =0;
        $noteModel = new NoteModel();
        $noteModel->setId($input['id']);
        
        $noteDomain      = new NoteDomain();
        $actualResultSet = $noteDomain->read($noteModel, $flag);
        
        $this->assertEquals(1, $actualResultSet[0]['id']);
        $this->assertEquals('PHP', $actualResultSet[0]['title']);
        $this->assertEquals('Preprocessor Hypertext', $actualResultSet[0]['body']);
    }
}
