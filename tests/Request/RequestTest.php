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
}
