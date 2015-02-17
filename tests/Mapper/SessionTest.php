<?php

namespace Notes\Mapper;

use Notes\Mapper\Session as SessionMapper;

use Notes\Config\Config as Configuration;


class SessionTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $connection;
    
    public function getConnection()
    {
        $config     = new Configuration();
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
        
        $sessionMapper->create($input);
        $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_insert.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    
    public function testDeleteEntry()
    {
        $noteMapper    = new SessionMapper();
        $resultset     = $noteMapper->delete('3');
        $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_delete.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
    
    public function testCanReadById()
    {
        $sessionMapper = new SessionMapper();
        $resultset     = $sessionMapper->read('1');
        $this->assertEquals("1", $resultset->userId);
    }
}
