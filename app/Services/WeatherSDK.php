<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class WeatherSDK implements WeatherSDKInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = 'API_KEY_1';
    }

    public function getWeather()
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->get('http://rocketapp:5000/weather');

        if ($response->failed()) {
            throw new \Exception('Unauthorized');
        }

        return $response->json();
    }

}