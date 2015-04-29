<?php
namespace Notes\Helper;

class WebTestCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testSetup()
    {
        $testCase = new WebTestCase();
        $testCase->setup();
        $slim = $testCase->getSlimInstance();
        $this->assertInstanceOf('\Slim\Slim', $slim);
    }
    public function testGetSlimInstance()
    {
        $expectedConfig = array(
            'version' => '0.0.0',
            'debug'   => false,
            'mode'    => 'testing'
        );
        $testCase = new WebTestCase();
        $slim = $testCase->getSlimInstance();
        $this->assertInstanceOf('\Slim\Slim', $slim);
        foreach ($expectedConfig as $key => $value) {
            $this->assertSame($expectedConfig[$key], $slim->config($key));
        }
    }
}