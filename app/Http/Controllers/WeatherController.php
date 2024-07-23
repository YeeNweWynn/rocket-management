<?php

namespace App\Http\Controllers;
use App\Services\WeatherSDKInterface;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherSDK;

    public function __construct(WeatherSDKInterface $weatherSDK)
    {
        $this->weatherSDK = $weatherSDK;
    }

    public function getWeatherData()
    {
        try {
            $data = $this->weatherSDK->getWeather();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
