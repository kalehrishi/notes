<?php

namespace Notes\Mapper;

use Notes\Mapper\Session as SessionMapper;
use Notes\Model\Session as SessionModel;

use Notes\Config\Config as Configuration;


class SessionTest extends \PHPUnit_Extensions_Database_TestCase
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
            $this->connection->exec("set foreign_key_checks=0");
            return $this->createDefaultDBConnection($this->connection, $dbName);
        }
        catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
    }
    
     public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_seed.xml');
    }
    
    public function testCreateNewSession()
    {
        $input         = array(
            
            'userId' => '1',
            'createdOn' => '2015-01-01 10:00:01',
            'expiredOn' => '2015-01-01 10:00:01'
        );
        $sessionMapper = new SessionMapper();
        $sessionModel = new SessionModel($input);
        $sessionMapper->create($sessionModel);
        $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_insert.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    public function testDeleteSession()
    {
         $input      = array(
            'id' => 1,
            'isExpired' => 1
        );
        $sessionMapper = new SessionMapper();
        $sessionModel = new SessionModel($input);
        $sessionMapper->delete($sessionModel);
        $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_delete.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }

    public function testUpdateSession()
    {

        $input = array(
            
                    
                    'id' => '1',
                    'userId' => '1',
                    'expiredOn' => '2015-01-01 01:00:01',
                    'isExpired' => '1'
                );
        $sessionMapper = new SessionMapper();
        $sessionModel = new SessionModel($input);
        $sessionMapper->delete($sessionModel);
        $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_update.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    public function testCanReadById()
    {   
        $input = array('id' => 2);

        $expectedResultset = array(
                    0 => array(
                     'id' => '2',
                    'userId' => '2',
                    'createdOn' => '2015-01-01 11:00:01',
                    'expiredOn' => '2015-01-10 01:01:01',
                    'isExpired' => '1'
                    )
            );
        $sessionMapper = new SessionMapper();
        $sessionModel  = new SessionModel($input);
        $resultset     =  $sessionMapper->read($sessionModel);
        $this->assertEquals($expectedResultset, $resultset);
    }


      
    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage invalid user
     */

     public function testFailesReadInvalidId()
    {  
       $input=['id'=>6];
       $sessionMapper = new SessionMapper();
        $sessionModel = new SessionModel($input);
       
        $resultset = $sessionMapper->read($sessionModel);
        
    }


}