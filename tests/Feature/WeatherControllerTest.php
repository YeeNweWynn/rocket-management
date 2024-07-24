<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\WeatherController;
use App\Services\WeatherSDKInterface;
use Illuminate\Http\JsonResponse;
use Mockery;

class WeatherControllerTest extends TestCase
{   
    public function testGetWeatherDataSuccess()
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
        $controller = new WeatherController($weatherSDKMock);

        $response = $controller->getWeatherData();
        //var_dump($response)
        
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(-11.748466552310932, $data['temperature']);
        $this->assertEquals(0.39264874787612714, $data['humidity']);
        $this->assertEquals(897.3813833548643, $data['pressure']);
        $this->assertEquals(0.5933966504184637, $data['precipitation']['probability']);
        $this->assertTrue($data['precipitation']['rain']);
        $this->assertFalse($data['precipitation']['snow']);
        $this->assertTrue($data['precipitation']['sleet']);
        $this->assertFalse($data['precipitation']['hail']);
        $this->assertEquals('2024-07-24T05:28:20.768401', $data['time']);
        $this->assertEquals('SE', $data['wind']['direction']);
        $this->assertEquals(49.6276458306951, $data['wind']['angle']);
        $this->assertEquals(4.754002148063797, $data['wind']['speed']);
    }

    public function testGetWeatherDataFailure()
    {
        $weatherSDKMock = Mockery::mock(WeatherSDKInterface::class);
        $weatherSDKMock->shouldReceive('getWeather')
            ->once()
            ->andThrow(new \Exception('API request failed'));
        $controller = new WeatherController($weatherSDKMock);

        $response = $controller->getWeatherData();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(401, $response->status());
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('API request failed', $data['error']);
    }
    
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
