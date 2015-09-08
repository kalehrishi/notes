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
        $this->assertInstanceOf('Notes\Response\Response', new Response());
    }
    /**
    * @test
    *
    */
    public function it_should_accept_data_and_return_in_json_format()
    {
        $data    = array(
            'firstName' => 'Joy',
            'lastName' => 'Mock',
            array(
                'tag' => 'Politics'
            )
        );
        
        $response = new Response($data);
        $this->assertJsonStringEqualsJsonFile(__dir__ . '/_files/json.js', $response->getResponse());
    }
}
