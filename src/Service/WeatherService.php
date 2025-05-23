<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class WeatherService
{
    public function __construct(
        private readonly string $apiKey,
        private readonly LoggerInterface $logger
    ) {
    }

    public function getWeatherData(string $city): array
    {
        $url = "https://api.weatherapi.com/v1/current.json?key={$this->apiKey}&q={$city}";
        
        try {
            $client = HttpClient::create();
            $response = $client->request('GET', $url, [
                'timeout' => 30,
            ]);
            
            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                $this->logger->error("Weather API returned non-200 status code: {$statusCode}");

                return ['error' => "API returned status code {$statusCode}"];
            }
            
            $data = $response->toArray();
            
            if (isset($data['error'])) {
                return ['error' => $data['error']['message']];
            }
            
            return [
                'city' => $data['location']['name'],
                'country' => $data['location']['country'],
                'temperature' => $data['current']['temp_c'],
                'condition' => $data['current']['condition']['text'],
                'humidity' => $data['current']['humidity'],
                'wind_speed' => $data['current']['wind_kph'],
                'last_updated' => $data['current']['last_updated'],
            ];
        } catch (ExceptionInterface $e) {
            $this->logger->error('HTTP client error: ' . $e->getMessage());

            return ['error' => 'Failed to connect to weather API: ' . $e->getMessage()];
        } catch (\Exception $e) {
            $this->logger->error('General error: ' . $e->getMessage());

            return ['error' => 'An error occurred while fetching weather data'];
        }
    }
}