<?php
include "bootstrap.php";
class GetMethodTest extends LocalWebTestCase
{
    public function testSayHello()
    {
        $this->client->get('/');
        $this->assertEquals(200, $this->client->response->status());
        //$this->assertSame('Wel-come to Sticky-notes', $this->client->response->body());
    }
}
