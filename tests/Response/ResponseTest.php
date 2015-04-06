<?php

namespace Notes\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @test
    *
    */
    public function it_should_create_object()
    {
        $this->assertInstanceOf('Notes\Response\Response', new Response(200, "ok", "1.0.0"));
    }
    /**
    * @test
    *
    */
    public function it_should_accept_data_and_return_in_json_format()
    {
        $status  = "200";
        $message = "ok";
        $data    = array(
            'firstName' => 'Joy',
            'lastName' => 'Mock',
            array(
                'tag' => 'Politics'
            )
        );
        
        $response = new Response($status, $message,$data);
        $this->assertJsonStringEqualsJsonFile(__dir__ . '/_files/json.js', $response->getResponse());
    }
}
