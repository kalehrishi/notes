<?php
namespace Notes\Helper;

use \Slim;


class WebTestClient
{
    public $application;
    public $request;
    public $response;
        
    public $testingMethods = array('get', 'post', 'patch', 'put', 'delete', 'head');
    
    /*public function __construct(Slim\Slim $slim)
    {   
        $this->app = $slim;
    }*/
    // Implement our `get`, `post`, and other http operations
    
    public function __call($method, $arguments)
    {
        if (in_array($method, $this->testingMethods)) {
            list($path, $data, $headers) = array_pad($arguments, 3, array());
            
            return($this->request($method, $path, $data, $headers));
        }
        throw new \BadMethodCallException(strtoupper($method) . ' is not supported');
    }
    
    // Abstract way to make a request to SlimPHP, this allows us to mock the
    // slim environment
    
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
       
        //print_r($options);     
        Slim\Environment::mock(array_merge($options, $optionalHeaders));
        
        $this->application = new \Slim\Slim(array(
                            'debug' => true ));
        
       // print_r($this->application->request->post());
        
        require "app/Router/Routes.php";

        $this->request  = $this->application->request();
        $this->response = $this->application->response();

        $this->application->run();
        
        return ob_get_clean(); 
    }
}
