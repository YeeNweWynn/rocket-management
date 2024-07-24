<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class WeatherSDK implements WeatherSDKInterface
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('APP_API_KEY', 'API_KEY_1');
        $this->apiUrl = env('APP_API_URL', 'http://rocketapp:5000');
    }

    public function getWeather(): ?array
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->get($this->apiUrl . '/weather');

        if ($response->failed()) {
            throw new \Exception('API request failed');
        }

        return $response->json();
    }

}