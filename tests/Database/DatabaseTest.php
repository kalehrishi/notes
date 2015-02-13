<?php

namespace Notes\Database;

class DatabaseTest extends \PHPUnit_Extensions_Database_TestCase
{
    public function getConnection()
    {
        $dbHost     = "localhost";
        $dbName     = "test_amit";
        $dbUser     = "developer";
        $dbPassword = "test123";
        
        $pdo = new \PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
        return $this->createDefaultDBConnection($pdo, $dbName);
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
        
        $query       = "select dbId,firstName,lastName,isdeleted from db_test";
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
        
        $query       = "select dbId,firstName,lastName,isdeleted from db_test where dbId=:id";
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
        $query       = "select dbId,firstName,lastName,isdeleted from db_test where dbId=:id and firstName=:name";
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
        
        $query  = "update db_test set isdeleted=:value where dbId=:id";
        $placeholder = array(
            ':id' => 1,
            ':value' => 1
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
        $query    = "update db_test set isdeleted=:value where dbId=:id";
        $placeholder = array(
            ':id' => 4,
            ':value' =>1
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
        $query       = "insert into db_test(firstName,lastName,isDeleted) values(:firstName,:lastName,:isDeleted)";
        $placeholder = array(
            ':firstName' => 'Jk',
            ':lastName' => 'mark',
            ':isDeleted' => 0
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
        
        $query  = "insert into db_test(firstName,lastName,isDeleted) values(:firstName,:lastName,:isDeleted)";
        $placeholder = array(
            ':firstName' => 'moses',
            ':lastName' => 'dark',
            ':isDeleted' => 0
        );
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->post($params);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/user_after_insert.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('db_test'));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
    public function testCanUpdateRecordCheckedByComparingActualDatabaseAndXmlFile()
    {
        $database = new Database();
        
        $query  = "update db_test set isdeleted=:value where dbId=:id";
        $placeholder = array(
            ':id' => 2,
            ':value' =>1
        );
        $params = array(
            'dataQuery' => $query,
            'placeholder' => $placeholder
        );
        $user   = $database->post($params);

        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__).'/user_after_update.xml');
        $actualDataSet = $this->getConnection()->createDataSet(array('db_test'));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
    }
}
