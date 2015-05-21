<?php

class LoginTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/');
    }

    public function testTitle()
    {
        $this->url('index.php/login');
        $this->assertEquals('Login', $this->title());

        $this->byName('email')->value("gau@bhapkar.com");
        $this->byName('password')->value("Gauri@123");
        $this->byCssSelector('form')->submit();
        $welcom=$this->byCssSelector('div');
        $this->assertEquals('Login', $this->title());
        $this->assertEquals('Html', $welcom);
        
    }
}
