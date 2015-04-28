<?php
namespace Notes\Demo;

// use There4\Slim\Test\WebTestCase;
// use There4\Slim\Test\WebTestClient;

class WebTestClientTest extends \PHPUnit_Framework_TestCase
{
    private $slim;
    /**
     * @dataProvider getValidRequests
     * @param string $name
     * @param string $uri
     * @param mixed $input
     */
    public function testValidRequests($name, $uri, $input)
    {
        $client = new WebTestClient($this->getSlimInstance());
        $expectedOutput = 'This is a test!';
        call_user_func(array($client, $name), $uri, $input);
        $this->assertSame(200, $client->response->status());
        $this->assertSame($expectedOutput, $client->response->body());
    }
    /**
     * @expectedException \BadMethodCallException
     */
    public function testInvalidRequestMethods()
    {
        $client = new WebTestClient($this->getSlimInstance());
        $client->foo($this->getValidUri());
    }
    public function getValidRequests()
    {
        $methods = $this->getValidRequestMethods();
        $uri = $this->getValidUri();
        return array_map(function ($value) use ($uri) {
            $input = ($value == 'post') ? 'test data' : array();
            return array($value, $uri, $input);
        }, $methods);
    }
    private function getSlimInstance()
    {
        if (!$this->slim) {
            $testCase = new WebTestCase();
            $this->slim = $testCase->getSlimInstance();
            $methods = $this->getValidRequestMethods();
            $callback = function () {
                echo 'This is a test!';
            };
            foreach ($methods as $method) {
                $this->slim->$method($this->getValidUri(), $callback);
            }
        }
        return $this->slim;
    }
    private function getValidRequestMethods()
    {
        return array('get', 'post', 'patch', 'put', 'delete');
    }
    private function getValidUri()
    {
        return '/testing';
    }
}