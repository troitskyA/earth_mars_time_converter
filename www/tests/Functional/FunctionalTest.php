<?php

class FunctionalTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testItReachesEndpointWith200()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(
            200,
            $response->status()
        );
    }

    public function testIfReturnsCorrectResponse()
    {
        $response = $this->call('GET', '/', ['dateTime' => '2020-09-23%2014:03:00']);

        $this->assertEquals(
            'Mars Sol Date: 52160.135914819<br/>Coordinated Mars Time: 03:15:43',
            $response->getContent()
        );
    }

    public function testIfReturnsErrorWithWrongResponse()
    {
        $response = $this->call('GET', '/', ['dateTime' => '2020-09-23%2014:03:00123']);

        $this->assertEquals(
            'Wrong Date Time',
            $response->getContent()
        );
    }
}
