<?php

class googleTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setHost('localhost');
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/');
    }
        /**
    *@large
    */

    public function testHomeTitle()
    {
        $this->url('index.php/');
        $this->assertEquals('Home', $this->title());
        
    }
    /**
    *@large
    */

    public function testTitle()
    {
        $this->url('index.php/login');
        $this->assertEquals('Login', $this->title());

        $this->byName('email')->value("gau@bhapkar.com");
        $this->byName('password')->value("Gauri@12");
        $this->byCssSelector('form')->submit();
        $welcom=$this->byCssSelector('div');
        $this->assertEquals('Login', $this->title());
        //$this->assertEquals('Html', $welcom);
        
    }

}
