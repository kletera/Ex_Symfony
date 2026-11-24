<?php

namespace App\Controller;

use App\Form\WeatherType;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class WeatherController extends AbstractController
{
    public function __construct(
        private readonly WeatherService $weather
    ) {}

    #[Route('/weather', name: 'app_weather')]
    public function index(): Response
    {

        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
            'data'=> $this->weather->getWeather(),
        ]);
    }

    #[Route('/weather/city', name: 'app_weather_city')]
    public function weatherByCity(Request $request): Response
    {
        $form = $this->createForm(WeatherType::class, null, [
        'attr' => ['data-turbo' => 'false'],
        ]);
        $form->handleRequest($request);
        $data = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->get('name')->getData();
            $data = $this->weather->getWeatherByName($name);

            if ($data) {
                $this->addFlash('notice', 'Ville trouvée');
            } else {
                $this->addFlash('error', 'Ville introuvable');
            }
        }
        return $this->render('weather/weatherByCity.html.twig', [
            'form' => $form,
            'data' => $data,
        ]);
    }

    
}