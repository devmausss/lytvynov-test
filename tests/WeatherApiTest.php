<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherApiTest extends WebTestCase
{
    public function testGetWeather()
    {
        $client = static::createClient();
        $client->request('GET', '/api/weather/London');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('city', $responseData);
        $this->assertArrayHasKey('country', $responseData);
        $this->assertArrayHasKey('temperature', $responseData);
        $this->assertArrayHasKey('condition', $responseData);
        $this->assertArrayHasKey('humidity', $responseData);
        $this->assertArrayHasKey('wind_speed', $responseData);
        $this->assertArrayHasKey('last_updated', $responseData);
    }

    public function testGetWeatherWithInvalidCity()
    {
        $client = static::createClient();
        $client->request('GET', '/api/weather/InvalidCityName123456789');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('error', $responseData);
    }
}