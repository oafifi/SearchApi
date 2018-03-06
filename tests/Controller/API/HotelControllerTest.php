<?php

namespace App\Tests\Controller\API;

use App\Controller\API\HotelController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HotelControllerTest extends WebTestCase
{

    public function testSearchHotels()
    {
        $client = static::createClient();
        $client->request('GET', '/api/search/hotels');

        $response = $client->getResponse();

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals('application/json',$response->headers->get('content-type'));
    }

    public function testSearchHotelsInvalidRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/api/search/hotels', ['dfgdg' => 'sfsgs']);

        $response = $client->getResponse();

        $this->assertEquals(400,$response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals('application/problem+json',$response->headers->get('content-type'));
    }
}
