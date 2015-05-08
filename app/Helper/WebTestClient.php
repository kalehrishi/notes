<?php
namespace Notes\Helper;

use \Slim;

class WebTestClient
{
    public $app;
    public $request;
    public $response;
        
    public $testingMethods = array('get', 'post', 'patch', 'put', 'delete', 'head');
    
    public function __call($method, $arguments)
    {
        if (in_array($method, $this->testingMethods)) {
            list($path, $data, $headers) = array_pad($arguments, 3, array());
            
            return($this->request($method, $path, $data, $headers));
        }
        throw new \BadMethodCallException(strtoupper($method) . ' is not supported');
    }

    private function request($method, $path, $data = array(), $optionalHeaders = array())
    {
        ob_start();

        $options = array(
            'REQUEST_METHOD' => strtoupper($method),
            'PATH_INFO'      => $path,
            'SERVER_NAME' => 'local.dev'
        );
      
        if ($method === 'get') {
            $options['QUERY_STRING'] = http_build_query($data);
        } elseif (is_array($data)) {
            $options['slim.input']   = http_build_query($data);
        } else {
            $options['slim.input']   = $data;
        }
       
        Slim\Environment::mock(array_merge($options, $optionalHeaders));

        $application = new \Slim\Slim(array(
                            'debug' => true,
                            'mode'=>'test'));
        
        $application->setName('developer');
        
        require "app/Router/Routes.php";
        
        $this->app=$application;
        $this->request  = $application->request();
        $this->response = $application->response();

        $application->run();
        
        return ob_get_clean();
    }
}
