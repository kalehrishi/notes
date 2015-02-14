<?php

namespace Notes\Database;

class DatabaseTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function getConnection()
    {
        $dbHost     = "localhost";
        $dbName     = "notes";
        $dbUser     = "developer";
        $dbPassword = "test123";
        
        $pdo = new \PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        return $this->createDefaultDBConnection($pdo, $dbName);
       // $pdo->exec("set foreign_key_checks=0");
    }
    
    public function getDataSet()
    {

        return $this->createXMLDataSet(dirname(__FILE__) . '/user_seed.xml');
    }
    public function testCanCreateObject()
    {
        $database = new Database();
        $this->assertInstanceOf('Notes\Database\Database', $database);
        
    }
    public function testCanReadRecord()
    {
        $database = new Database();
        
        $query       = "select id,firstName,lastName,email,password,createdOn from Users";
        $placeholder = null;
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->get($params);
        $this->assertEquals('2', count($user));
    }
    public function testCanReadUserByOnePlaceholder()
    {
        $database = new Database();
        
        $query       = "select id,firstName,lastName,email,password,createdOn from Users where id=:id";
        $placeholder = array(
            ':id' => '1'
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->get($params);
        
        $this->assertEquals('harry', $user[0]['firstName']);
    }
    public function testCanReadUserByTwoPlaceholders()
    {   
        $database    = new Database();
        $id          = 2;
        $name        = 'joy';
        $query       = "select id,firstName,lastName,email,password,createdOn from Users where id=:id and firstName=:name";
        $placeholder = array(
            ':id' => $id,
            ':name' => $name
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->get($params);
        $this->assertEquals('kris', $user[0]['lastName']);
    }
    
    public function testCanUpdateRecordCheckedByNumberOfAffectedRow()
    {
        $database = new Database();
        
        $query  = "update Users set firstName=:name where id=:id";
        $placeholder = array(
            ':id' => 1,
            ':name' =>"amit" 
        );
        $params = array(
            'dataQuery' => $query,
            'placeholder' =>$placeholder
        );
        $result   = $database->post($params);
        $this->assertEquals(1, $result['rowCount']);
    }
    public function testUpdatingRecordFailed()
    {   
        $database = new Database();
        $query    = "update Users set firstName=:name where id=:id";
        $placeholder = array(
            ':id' => 4,
            ':name' =>'amit'
        );
        $params   = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $result     = $database->post($params);
        
        $this->assertEquals(0, $result['rowCount']);
    }
    public function testCanInsertRecordCheckedById()
    {   
        $database    = new Database();
        $query       = "insert into Users(firstName,lastName,email,password) values(:firstName,:lastName,:email,:password)";
        $placeholder = array(
            ':firstName' => 'krish',
            ':lastName' => 'rajesh',
            ':email' => 'abc@xyz.com',
            ':password'=>"678910"
        );
        
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $result   = $database->post($params);
        
        $this->assertEquals(3, $result['lastInsertId']);
    }
    public function testCanInsertRecordCheckedByComparingActualDatabaseAndXmlFile()
    {
        $database = new Database();
        
        $query  = "insert into Users(firstName,lastName,email,password) values(:firstName,:lastName,:email,:password)";
        $placeholder = array(
            ':firstName' => 'krish',
            ':lastName' => 'rajesh',
            ':email' => 'abc@xyz.com',
            ':password'=>"678910"
        );
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->post($params);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/user_after_insert.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('Users'));
        $filterDataSet = new \PHPUnit_Extensions_Database_DataSet_DataSetFilter($actualDataSet);
        $filterDataSet->setExcludeColumnsForTable('Users', array('createdOn'));
        $this->assertDataSetsEqual($expectedDataSet, $filterDataSet);
    }
    public function testCanUpdateRecordCheckedByComparingActualDatabaseAndXmlFile()
    {
        $database = new Database();
       
        $query  = "update Users set firstName=:name where id=:id";
        $placeholder = array(
            ':id' => 2,
            ':name' =>'amit'
        );
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->post($params);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/_files/user_after_update.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('Users'));
        $filterDataSet = new \PHPUnit_Extensions_Database_DataSet_DataSetFilter($actualDataSet);
        $filterDataSet->setExcludeColumnsForTable('Users', array('createdOn'));
        $this->assertDataSetsEqual($expectedDataSet, $filterDataSet);
    }
}
