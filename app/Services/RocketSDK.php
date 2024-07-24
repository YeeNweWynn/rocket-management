<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class RocketSDK implements RocketSDKInterface
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('APP_API_KEY', 'API_KEY_1');
        $this->apiUrl = env('APP_API_URL', 'http://rocketapp:5000');
    }

    public function getRockets(): ?array 
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->get($this->apiUrl .'/rockets');

        if ($response->failed()) {
            throw new \Exception('API request failed');
        }

        return $response->json();
    }

    public function updateRocketStatus($id): ?array
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->put($this->apiUrl . "/rocket/{$id}/status/launched");

        if ($response->failed()) {
            throw new \Exception('Failed to update rocket status');
        }

        return $response->json();
    }

    public function cancelRocket($id): ?array
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->delete($this->apiUrl . "/rocket/{$id}/status/launched");

        if ($response->failed()) {
            throw new \Exception('Failed to cancel rocket');
        }

        return $response->json();
    }
}