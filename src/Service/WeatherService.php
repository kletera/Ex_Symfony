<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    public function __construct(
        private readonly string $apiKey,
        private readonly HttpClientInterface $httpClient
    ) {}

    public function getWeather(string $ion="1.44", string $lat="43"): array
    {
        $url = "https://api.openweathermap.org/data/2.5/weather?lon=".$ion."&lat=".$lat."&appid=" . $this->apiKey . "&units=metric";

        try {
            $response = $this->httpClient->request(
                'GET',
                $url
            );
            return $response->toArray();
        } catch(\Exception $e) {

        }
       return [];
    }

    public function getWeatherByName(string $name){

        $cities = "http://api.openweathermap.org/geo/1.0/direct?q=".$name."&appid=" . $this->apiKey. "&units=metric";

        try {
            $response = $this->httpClient->request(
                'GET',
                $cities
            );
            $results=$response->toArray();
            $lat =$results[0]['lat'];
            $ion = $results[0]['lon'];
            return $this->getWeather($ion, $lat);
        } catch(\Exception $e) {

        }
    }
}