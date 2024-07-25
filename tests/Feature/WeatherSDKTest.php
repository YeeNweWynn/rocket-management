<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\WeatherSDK;
use Mockery;
use Illuminate\Support\Facades\Http;

class WeatherSDKTest extends TestCase
{
    public function testGetWeatherSuccess(): void
    {
        $weatherSDKMock = Mockery::mock(WeatherSDKInterface::class);
        $weatherSDKMock->shouldReceive('getWeather')
            ->once()
            ->andReturn([
                'temperature' => -11.748466552310932,
                'humidity' => 0.39264874787612714,
                'pressure' => 897.3813833548643,
                'precipitation' => [
                    'probability' => 0.5933966504184637,
                    'rain' => true,
                    'snow' => false,
                    'sleet' => true,
                    'hail' => false,
                ],
                'time' => '2024-07-24T05:28:20.768401',
                'wind' => [
                    'direction' => 'SE',
                    'angle' => 49.6276458306951,
                    'speed' => 4.754002148063797,
                ],
            ]);

        $result = $weatherSDKMock->getWeather();
        //var_dump($result);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('temperature', $result);
        $this->assertArrayHasKey('humidity', $result);
        $this->assertArrayHasKey('pressure', $result);
        $this->assertArrayHasKey('precipitation', $result);
        $this->assertArrayHasKey('time', $result);
        $this->assertArrayHasKey('wind', $result);
    
        $this->assertIsFloat($result['temperature']);
        $this->assertIsFloat($result['humidity']);
        $this->assertIsFloat($result['pressure']);
        $this->assertIsArray($result['precipitation']);
        $this->assertIsString($result['time']);
        $this->assertIsArray($result['wind']);
    
        $this->assertArrayHasKey('probability', $result['precipitation']);
        $this->assertArrayHasKey('rain', $result['precipitation']);
        $this->assertArrayHasKey('snow', $result['precipitation']);
        $this->assertArrayHasKey('sleet', $result['precipitation']);
        $this->assertArrayHasKey('hail', $result['precipitation']);
    
        $this->assertIsFloat($result['precipitation']['probability']);
        $this->assertIsBool($result['precipitation']['rain']);
        $this->assertIsBool($result['precipitation']['snow']);
        $this->assertIsBool($result['precipitation']['sleet']);
        $this->assertIsBool($result['precipitation']['hail']);
    
        $this->assertArrayHasKey('direction', $result['wind']);
        $this->assertArrayHasKey('angle', $result['wind']);
        $this->assertArrayHasKey('speed', $result['wind']);
    
        $this->assertIsString($result['wind']['direction']);
        $this->assertIsFloat($result['wind']['angle']);
        $this->assertIsFloat($result['wind']['speed']);
    }
    
    public function testGetWeatherFailure()
    {
        $weatherSDKMock = Mockery::mock(WeatherSDKInterface::class);
        $weatherSDKMock->shouldReceive('getWeather')
            ->once()
            ->andThrow(new \Exception('API request failed'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('API request failed');
        $weatherSDKMock->getWeather();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
