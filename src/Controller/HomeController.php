<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherService;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly WeatherService $weatherService
    ) {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $cities = ['Cherkasy', 'Kyiv', 'Warsaw'];
        $weatherData = [];

        foreach ($cities as $city) {
            $weatherData[$city] = $this->weatherService->getWeatherData($city);
        }

        return $this->render('home/index.html.twig', [
            'weatherData' => $weatherData,
        ]);
    }
}