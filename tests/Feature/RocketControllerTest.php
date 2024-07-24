<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\RocketSDKInterface;
use Mockery;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\RocketController;

class RocketControllerTest extends TestCase
{
    public function testGetOverviewDataSuccess(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('getRockets')
            ->once()
            ->andReturn([
                [
                    "id" => "DSSvW7VLmb",
                    "model" => "Saturn V",
                    "mass" => 2970000,
                    "payload" => [
                        "description" => "Apollo CSM-109 Odyssey, Apollo LM-7 Aquarius, 3 Astronauts",
                        "weight" => 1542
                    ],
                    "telemetry" => [
                        "host" => "0.0.0.0",
                        "port" => 4000
                    ],
                    "status" => "launched",
                    "timestamps" => [
                        "launched" => "2024-07-24T06:03:29.596571",
                        "deployed" => null,
                        "failed" => null,
                        "cancelled" => "2024-07-24T04:48:11.484383"
                    ],
                    "altitude" => 0.0,
                    "speed" => 0.0,
                    "acceleration" => 0.0,
                    "thrust" => 35100000,
                    "temperature" => 0.0
                ]
            ]);

        $controller = new RocketController($rocketSDKMock);

        $response = $controller->getOverviewData();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertCount(1, $data);
        $this->assertEquals('DSSvW7VLmb', $data[0]['id']);
        $this->assertEquals('Saturn V', $data[0]['model']);
        $this->assertEquals(2970000, $data[0]['mass']);
        $this->assertEquals('Apollo CSM-109 Odyssey, Apollo LM-7 Aquarius, 3 Astronauts', $data[0]['payload']['description']);
        $this->assertEquals(1542, $data[0]['payload']['weight']);
        $this->assertEquals('0.0.0.0', $data[0]['telemetry']['host']);
        $this->assertEquals(4000, $data[0]['telemetry']['port']);
        $this->assertEquals('launched', $data[0]['status']);
        $this->assertEquals('2024-07-24T06:03:29.596571', $data[0]['timestamps']['launched']);
        $this->assertNull($data[0]['timestamps']['deployed']);
        $this->assertNull($data[0]['timestamps']['failed']);
        $this->assertEquals('2024-07-24T04:48:11.484383', $data[0]['timestamps']['cancelled']);
        $this->assertEquals(0.0, $data[0]['altitude']);
        $this->assertEquals(0.0, $data[0]['speed']);
        $this->assertEquals(0.0, $data[0]['acceleration']);
        $this->assertEquals(35100000, $data[0]['thrust']);
        $this->assertEquals(0.0, $data[0]['temperature']);
    }

    public function testGetOverviewDataFailure(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('getRockets')
            ->once()
            ->andThrow(new \Exception('API request failed'));

        $controller = new RocketController($rocketSDKMock);

        $response = $controller->getOverviewData();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('API request failed', $data['error']);
    }

    public function testUpdateRocketStatusSuccess(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('updateRocketStatus')
            ->once()
            ->andReturn(['status' => 'launched']);

        $controller = new RocketController($rocketSDKMock);

        $response = $controller->updateRocketStatus(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Rocket status updated successfully', $data['message']);
    }

    public function testUpdateRocketStatusFailure(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('updateRocketStatus')
            ->once()
            ->andThrow(new \Exception('Failed to update rocket status'));

        $controller = new RocketController($rocketSDKMock);

        $response = $controller->updateRocketStatus(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Failed to update rocket status', $data['error']);
    }

    public function testCancelRocketSuccess(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('cancelRocket')
            ->once()
            ->andReturn(['status' => 'cancelled']);

        $controller = new RocketController($rocketSDKMock);

        $response = $controller->cancelRocket(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Successfully cancelled rocket.', $data['message']);
    }

    public function testCancelRocketFailure(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('cancelRocket')
            ->once()
            ->andThrow(new \Exception('Failed to cancel rocket'));

        $controller = new RocketController($rocketSDKMock);

        $response = $controller->cancelRocket(1);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Failed to cancel rocket', $data['error']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
