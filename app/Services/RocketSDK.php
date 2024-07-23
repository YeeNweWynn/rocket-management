<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class RocketSDK implements RocketSDKInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = 'API_KEY_1';
    }

    public function getRockets()
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->get('http://rocketapp:5000/rockets');

        if ($response->failed()) {
            throw new \Exception('Unauthorized');
        }

        return $response->json();
    }

    public function updateRocketStatus($id)
    {
        $response = Http::withHeaders([
            "x-api-key" => $this->apiKey
        ])->put("http://rocketapp:5000/rocket/{$id}/status/launched");

        if ($response->failed()) {
            throw new \Exception('Failed to update rocket status');
        }

        return $response->json();
    }
}