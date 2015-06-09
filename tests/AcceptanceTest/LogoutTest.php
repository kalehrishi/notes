<?php
use Notes\Config\Config as Configuration;


class LogoutTest extends \PHPUnit_Framework_TestCase 
{
    public function testprint()
    {
        $config     = new Configuration("config.json");
        $configData = $config->get();
        $dbHost     = $configData['jobname'];
        echo "-----------".$dbHost;
    }
    
    
}
