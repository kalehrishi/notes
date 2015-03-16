<?php
namespace Notes\Database;

use Notes\Config\Config as Configuration;

class Database
{
    private $connection;
    
    public function __construct()
    {
        
        
        $config     = new Configuration("config.json");
        $configData = $config->get();
        $dbHost     = $configData['dbHost'];
        $dbName     = $configData['dbName'];
        $hostString = "mysql:host=$dbHost;dbname=$dbName";
        try {
            $this->connection = new \PDO($hostString, $configData['dbUser'], $configData['dbPassword']);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    public function get($input)
    {
        $queryString    = $input['dataQuery'];
        $data           = $input['placeholder'];
        $queryStatement = $this->connection->prepare($queryString);
        $queryStatement->execute($data);
        $resultset = $queryStatement->fetchAll(\PDO::FETCH_ASSOC);
        return $resultset;
    }
    
    public function post($input)
    {
        $queryString    = $input['dataQuery'];
        $data           = $input['placeholder'];
        $queryStatement = $this->connection->prepare($queryString);
        $queryStatement->execute($data);
        return array(
            'rowCount' => $queryStatement->rowCount(),
            'lastInsertId' => $this->connection->lastInsertId()
        );
    }
    
    public function update($input)
    {
        $queryString    = $input['dataQuery'];
        $data           = $input['placeholder'];
        $queryStatement = $this->connection->prepare($queryString);
        $queryStatement->execute($data);
        $affectedRows   = $queryStatement->rowCount();
        return $affectedRows;
    }
    
    public function close()
    {
        $this->connection = null;
    }
}
