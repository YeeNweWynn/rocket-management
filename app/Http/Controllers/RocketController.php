<?php

namespace App\Http\Controllers;
use App\Services\RocketSDKInterface;

use Illuminate\Http\Request;

class RocketController extends Controller
{
    protected $rocketSDK;

    public function __construct(RocketSDKInterface $rocketSDK)
    {
        $this->rocketSDK = $rocketSDK;
    }

    public function getOverviewData()
    {
        try {
            $data = $this->rocketSDK->getRockets();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    public function updateRocketStatus($id)
    {
        try {
            $this->rocketSDK->updateRocketStatus($id);
            return response()->json(['message' => 'Rocket status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
