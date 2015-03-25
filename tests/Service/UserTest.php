<?php
namespace Notes\Service;

use Notes\Service\User as UserService;

use Notes\Model\User as UserModel;

use Notes\Config\Config as Configuration;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Domain\User as UserDomain;

class UserTest extends \PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/user_seed.xml');
    }
    
    
    /**
     * @test
     *
     **/
    
    public function it_should_create_user()
    {
        $userInput = array(
            'firstName' => 'kirti',
            'lastName' => 'ramani',
            'email' => 'kirti.6@gmail.com',
            'password' => 'abc@$#A123',
            'createdOn' => '2014-10-31 20:59:59'
            
        );
        
        
        
        $userModel = new UserModel();
        
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        $userModel->setCreatedOn($userInput['createdOn']);
        
        
        $userService     = new UserService();
        $userModel       = $userService->createUser($userInput);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('kirti', $userModel->getFirstName());
        $this->assertEquals('ramani', $userModel->getLastName());
        $this->assertEquals('kirti.6@gmail.com', $userModel->getEmail());
        $this->assertEquals('abc@$#A123', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        
    }
    
    
    
    /**
     * @test
     *
     **/
    
    public function it_should_read_user_by_email_and_password()
    {
        
        $userInput = array(
            'email' => 'anusha@gmail.com',
            'password' => 'sfhsk1223'
            
        );
        
        
        $userModel = new UserModel();
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        
        
        $userService     = new UserService();
        $userModel       = $userService->readUser($userInput);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhsk1223', $userModel->getPassword());
        
        
        
    }
    
    /**
     * @test
     * @expectedException Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    
    public function it_should_throw_exception_when_username_password_does_not_match()
    {
        
        $userInput = array(
            
            'email' => 'anusha@gmil.com',
            'password' => 'sfhs1223'
        );
        $userModel = new UserModel();
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        
        
        $userService = new UserService();
        $userModel   = $userService->readUser($userInput);
    }
    
    /**
     * @test
     *
     **/
    public function it_should_update_user()
    {
        $userInput = array(
            'id' => 1,
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhA@k1223',
            'createdOn' => '2014-10-29 20:59:59'
            
        );
        
        
        $userModel = new UserModel();
        
        $userModel->setId($userInput['id']);
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        $userModel->setCreatedOn($userInput['createdOn']);
        
        $userService     = new UserService();
        $userModel       = $userService->updateUser($userInput);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_update.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('julie', $userModel->getFirstName());
        $this->assertEquals('shah', $userModel->getLastName());
        $this->assertEquals('priya@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhA@k1223', $userModel->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $userModel->getCreatedOn());
        
    }
    
    
    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Password Strength is weak
     */
    
    public function it_should_throw_exceptionwhenupdationfailed()
    {
        
        $userInput     = array(
            'firstName' => 'priyanka',
            'lastName' => 'kumar',
            'email' => 'kumar.6@gmail.com',
            'password' => 'sfhsk1229'
            
        );
        $userModel = new UserModel();
        $userModel->setFirstName($userInput['firstName']);
        $userModel->setLastName($userInput['lastName']);
        $userModel->setEmail($userInput['email']);
        $userModel->setPassword($userInput['password']);
        
        $userService = new UserService();
        $userModel   = $userService->updateUser($userInput);
        
        
        
    }
}
