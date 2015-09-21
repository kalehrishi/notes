<?php
namespace Notes\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{   

    public function testCanAcceptConfigurationForIntegrationEnviornment()
    {   
        $config=new Config("config_integration.json");
        $result=$config->get();
        $this->assertEquals("notes-mysql", $result['dbHost']);
        $this->assertEquals("notes-@GIT_BRANCH", $result['dbName']);
        $this->assertEquals("developer", $result['dbUser']);
        $this->assertEquals("test123", $result['dbPassword']);
    }    

    public function testCanAcceptConfigurationForDevEnviornment()
    {   
        $config=new Config("config_dev.json");
        $result=$config->get();
        $this->assertEquals("notes-mysql", $result['dbHost']);
        $this->assertEquals("notes-@GIT_BRANCH", $result['dbName']);
        $this->assertEquals("developer", $result['dbUser']);
        $this->assertEquals("test123", $result['dbPassword']);
    }    

    public function testCanAcceptConfigurationForBetaEnviornment()
    {   
        $config=new Config("config_beta.json");
        $result=$config->get();
        $this->assertEquals("notes-mysql", $result['dbHost']);
        $this->assertEquals("notes-@GIT_BRANCH", $result['dbName']);
        $this->assertEquals("developer", $result['dbUser']);
        $this->assertEquals("test123", $result['dbPassword']);
    }    

    public function testCanAcceptConfigurationForMasterEnviornment()
    {   
        $config=new Config("config_master.json");
        $result=$config->get();
        $this->assertEquals("notes-mysql", $result['dbHost']);
        $this->assertEquals("notes-@GIT_BRANCH", $result['dbName']);
        $this->assertEquals("developer", $result['dbUser']);
        $this->assertEquals("test123", $result['dbPassword']);
    }  
}
