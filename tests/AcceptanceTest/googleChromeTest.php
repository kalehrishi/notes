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
    * @large
    **/
     public function testHomeTitle()
    {   
        $name=getenv("JobName");
        $this->url("$name/public/index.php/register");
        $this->byName('firstName')->value("jonh");
        $this->byName('lastName')->value("Mock");
        $this->byName('email')->value("jonh@mock.com");
        $this->byName('password')->value("Mock@1234");
        $this->byCssSelector('form')->submit();
        $this->assertEquals('Login', $this->title());
        $this->byName('email')->value("jonh@mock.com");
        $this->byName('password')->value("Mock@1234");
        $this->byCssSelector('form')->submit();
        $this->assertEquals('Notes | Home', $this->title());        

        
        
    }
        /**
    * @large
    **/

    public function testTitle()
    {
        $name=getenv("JobName");
        $this->url("$name/public/index.php/login");
        $this->assertEquals('Login', $this->title());

        $this->byName('email')->value("gau@bhapkar.com");
        $this->byName('password')->value("Gauri@12");
        $this->byCssSelector('form')->submit();
        $welcom=$this->byCssSelector('div');
        $this->assertEquals('Login', $this->title());
        //$this->assertEquals('Html', $welcom);
        
    }
   
}
