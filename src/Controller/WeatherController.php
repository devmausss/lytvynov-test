<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherService;
use Psr\Log\LoggerInterface;

#[Route("/api", name: "api_")]
class WeatherController extends AbstractController
{
    public function __construct(
        private readonly WeatherService $weatherService,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route("/weather/{city}", name: "get_weather", methods: ["GET"])]
    public function getWeather(string $city): JsonResponse
    {
        try {
            $weatherData = $this->weatherService->getWeatherData($city);

            if (isset($weatherData['error'])) {
                $this->logger->error('Weather API error: ' . $weatherData['error']);
                return $this->json(['error' => $weatherData['error']], 400);
            }

            $this->logger->info("Weather data retrieved for {$weatherData['city']}: {$weatherData['temperature']}°C, {$weatherData['condition']}");

            return $this->json($weatherData);
        } catch (\Exception $e) {
            $this->logger->error('Error getting weather data: ' . $e->getMessage());
            return $this->json(['error' => 'An error occurred while fetching weather data'], 500);
        }
    }
}
