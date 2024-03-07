<?php

// src/Controller/WeatherController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function index(): Response
    {
        $apiKey = 'e66dcbd7f9eb654b8239f8afcf6116f9';
        $city = 'Tunisia'; // ou n'importe quelle autre ville

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}");

        $data = $response->toArray();

        return $this->render('weather/index.html.twig', [
            'weatherData' => $data,
        ]);
    }
}

