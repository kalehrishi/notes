<?php

namespace Notes\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    public function it_should_create_object()
    {
        $this->assertInstanceOf('Notes\Request\Request', new Request());
    }
    /**
     * @test
     *
     */
    public function it_should_accept_json_data_and_decode_into_array()
    {
        $data    = '{
                "version":"1.0.0", 
                "platform": "Windows",
                "data": {
                            "firstName": "sme note",
                            "lastName": "body",
                            "email" : "amit.heda@gmai.com",
                            "password" :"demO@123",
                            "createdOn" :"2014-2-4 12:41:36"
                        }   
                }';
        $request = new Request();
        $request->setData($data);
        $this->assertJsonStringEqualsJsonString(json_encode($request->getData()), $data);
    }
    /**
    * @test
    *
    */
    public function it_should_set_headers_urlParams_and_cookies()
    {
        $headers    = array(
                        'Host' => 'notes.com',
                        'Connection' => 'keep-alive',
                        'Content-Length' => 246,
                        'Cache-Control' => 'no-cache',
                        'Origin' => 'chrome-extension://mkhojklkhkdaghjjfdnphfphiaiohkef',
                        'Client-Header' => 'Header Test',
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36',
                        'Content-Type' => 'text/plain',
                        'charset'=>'UTF-8' ,
                        'Accept-Encoding' => 'gzip, deflate'
                        );
        $urlParams = array(
                        'firstName' => 'Joy',
                        'lastName' => 'mock'
                        );
        $cookies = array(
                        'firstName' => 'Joy'
                        );

        $request = new Request();
        $request->setHeaders($headers);
        $request->setUrlParams($urlParams);
        $request->setCookies($cookies);

        $this->assertEquals($headers,$request->getHeaders());
        $this->assertEquals($urlParams,$request->getUrlParams());
        $this->assertEquals($cookies,$request->getCookies());

    }
    
}
