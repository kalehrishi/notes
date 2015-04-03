<?php
namespace Notes\Domain;

use Notes\Mapper\User as UserMapper;

use Notes\Model\User as UserModel;

use Notes\Config\Config as Configuration;

use Notes\Exception\ModelNotFoundException as ModelNotFoundException;

use Notes\Factory\User as UserFactory;

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
    
    

    public function testCanInsertRecord()
    {
        $input = array(
            'firstName' => 'kirti',
            'lastName' => 'ramani',
            'email' => 'kirti.6@gmail.com',
            'password' => 'abc@$#A123',
            'createdOn' => '2014-10-31 20:59:59'
        );
        $userFactory     = new UserFactory();
        $userModel       = $userFactory->create($input);
        $userDomain      = new User();
        $userModel       = $userDomain->create($input);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_insert.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        
        $this->assertEquals(3, $userModel->getId());
        $this->assertEquals('kirti', $userModel->getFirstName());
        $this->assertEquals('ramani', $userModel->getLastName());
        $this->assertEquals('kirti.6@gmail.com', $userModel->getEmail());
        $this->assertEquals('abc@$#A123', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    
    
    public function testCanReadRecordById()
    {
        $input           = array(
            'id' => 1
            
        );
        $userFactory     = new UserFactory();
        $userModel       = $userFactory->create($input);
        $userDomain      = new User();
        $userModel       = $userDomain->read($input);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('anushA@h21', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    /**
     * @expectedException         Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage   Can Not Found Given Model In Database
     */
    
    public function testUserCanThrowExceptionWhenUserIdDoesNotExist()
    {
        
        $input = array(
            'id' => 4
            
        );
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $userDomain  = new User();
        $userModel   = $userDomain->read($input);
        
        
    }
    public function testCanReadRecordByUsernameAndPassword()
    {
        $input           = array(
            'email' => 'anusha@gmail.com',
            'password' => 'anushA@h21'
        );
        $userFactory     = new UserFactory();
        $userModel       = $userFactory->create($input);
        $userDomain      = new User();
        $userModel       = $userDomain->readByUsernameandPassword($input);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('anusha', $userModel->getFirstName());
        $this->assertEquals('hiremath', $userModel->getLastName());
        $this->assertEquals('anusha@gmail.com', $userModel->getEmail());
        $this->assertEquals('anushA@h21', $userModel->getPassword());
        $this->assertEquals('2014-10-31 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
    }
    
    /**
     * @expectedException        Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    
    public function testUserCanThrowModelNotFoundExceptionWhenUserNamePasswordDoesNotMatch()
    {
        
        $input = array(
            'email' => 'anusha@gmail.com',
            'password' => 'aushA@h212'
        );
        
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);

        $userDomain  = new User();
        $userModel   = $userDomain->readByUsernameandPassword($input);
        
    }
    
    
    
    public function testCanUpdateRecord()
    {
        $input           = array(
            'id' => 1,
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhZ@223',
            'createdOn' => '2014-10-29 20:59:59'
        );
        $userFactory     = new UserFactory();
        $userModel       = $userFactory->create($input);
        $userDomain      = new User();
        $userModel       = $userDomain->update($input);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/user_after_update.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Users'
        ));
        $this->assertEquals(1, $userModel->getId());
        $this->assertEquals('julie', $userModel->getFirstName());
        $this->assertEquals('shah', $userModel->getLastName());
        $this->assertEquals('priya@gmail.com', $userModel->getEmail());
        $this->assertEquals('sfhZ@223', $userModel->getPassword());
        $this->assertEquals('2014-10-29 20:59:59', $userModel->getCreatedOn());
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        
        
        
    }
    
    /**
     * @test
     *@expectedException          InvalidArgumentException
     * @expectedExceptionMessage   Input should be Number
     */
    public function it_should_throw_exception_when_id_not_present_for_updating_user()
    {
        
        $input       = array(
            'id' => '',
            'firstName' => 'julie',
            'lastName' => 'shah',
            'email' => 'priya@gmail.com',
            'password' => 'sfhZ@223',
            'createdOn' => '2014-10-29 20:59:59'
        );
        $userFactory = new UserFactory();
        $userModel   = $userFactory->create($input);
        $userDomain  = new User();
        $userModel   = $userDomain->update($input);
        
        
        
    }
}
