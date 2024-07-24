<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\RocketSDKInterface;
use Mockery;
use Illuminate\Support\Facades\Http;

class RocketSDKTest extends TestCase
{
    public function testGetRocketsSuccess(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('getRocket')
            ->once()
            ->andReturn([
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
            ]);
    
        $result = $rocketSDKMock->getRocket();
    
        $this->assertIsArray($result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('model', $result);
        $this->assertArrayHasKey('mass', $result);
        $this->assertArrayHasKey('payload', $result);
        $this->assertArrayHasKey('telemetry', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('timestamps', $result);
        $this->assertArrayHasKey('altitude', $result);
        $this->assertArrayHasKey('speed', $result);
        $this->assertArrayHasKey('acceleration', $result);
        $this->assertArrayHasKey('thrust', $result);
        $this->assertArrayHasKey('temperature', $result);
    
        $this->assertIsString($result['id']);
        $this->assertIsString($result['model']);
        $this->assertIsInt($result['mass']);
        $this->assertIsArray($result['payload']);
        $this->assertIsArray($result['telemetry']);
        $this->assertIsString($result['status']);
        $this->assertIsArray($result['timestamps']);
        $this->assertIsFloat($result['altitude']);
        $this->assertIsFloat($result['speed']);
        $this->assertIsFloat($result['acceleration']);
        $this->assertIsInt($result['thrust']);
        $this->assertIsFloat($result['temperature']);
    
        $this->assertArrayHasKey('description', $result['payload']);
        $this->assertArrayHasKey('weight', $result['payload']);
        $this->assertIsString($result['payload']['description']);
        $this->assertIsInt($result['payload']['weight']);
    
        $this->assertArrayHasKey('host', $result['telemetry']);
        $this->assertArrayHasKey('port', $result['telemetry']);
        $this->assertIsString($result['telemetry']['host']);
        $this->assertIsInt($result['telemetry']['port']);
    
        $this->assertArrayHasKey('launched', $result['timestamps']);
        $this->assertArrayHasKey('deployed', $result['timestamps']);
        $this->assertArrayHasKey('failed', $result['timestamps']);
        $this->assertArrayHasKey('cancelled', $result['timestamps']);
        $this->assertIsString($result['timestamps']['launched']);
        $this->assertNull($result['timestamps']['deployed']);
        $this->assertNull($result['timestamps']['failed']);
        $this->assertIsString($result['timestamps']['cancelled']);
    }
    
    public function testGetRocketFailure(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('getRocket')
            ->once()
            ->andThrow(new \Exception('API request failed'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('API request failed');
        $rocketSDKMock->getRocket();
    }

    public function testUpdateRocketStatusSuccess(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('updateRocketStatus')
            ->with(1)
            ->once()
            ->andReturn(['id' => 1, 'status' => 'launched']);

        $result = $rocketSDKMock->updateRocketStatus(1);
        $this->assertIsArray($result);
        $this->assertEquals('launched', $result['status']);
    }

    public function testUpdateRocketStatusFailure(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('updateRocketStatus')
            ->with(1)
            ->once()
            ->andThrow(new \Exception('Failed to update rocket status'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to update rocket status');
        $rocketSDKMock->updateRocketStatus(1);
    }

    public function testCancelRocketSuccess(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('cancelRocket')
            ->with(1)
            ->once()
            ->andReturn(['id' => 1, 'status' => 'cancelled']);

        $result = $rocketSDKMock->cancelRocket(1);
        $this->assertIsArray($result);
        $this->assertEquals('cancelled', $result['status']);
    }

    public function testCancelRocketFailure(): void
    {
        $rocketSDKMock = Mockery::mock(RocketSDKInterface::class);
        $rocketSDKMock->shouldReceive('cancelRocket')
            ->with(1)
            ->once()
            ->andThrow(new \Exception('Failed to cancel rocket'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to cancel rocket');
        $rocketSDKMock->cancelRocket(1);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
