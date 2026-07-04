<?php

namespace App\Http\Services;

use App\Http\Repositories\WeatherApiRepository;

class WeatherApiService
{
    public function __construct(private readonly WeatherApiRepository $repository) {}


    public function getData(float $lat, float $lon, string $units = 'metric'): array
    {
        $record = $this->repository->getWeatherData($lat, $lon, ['units' => $units]);

        if (empty($record)) {
            throw new \RuntimeException('Weather API returned no data for these coordinates.');
        }

        return [
            'observed_at' => $record['dt'] ?? null,
            'sunrise' => $record['sys']['sunrise'] ?? null,
            'sunset' => $record['sys']['sunset'] ?? null,
            'temp' => $record['main']['temp'] ?? null,
            'feels_like' => $record['main']['feels_like'] ?? null,
            'pressure' => $record['main']['pressure'] ?? null,
            'humidity' => $record['main']['humidity'] ?? null,
            'clouds' => $record['clouds']['all'] ?? null,
            'visibility' => $record['visibility'] ?? null,
            'wind_speed' => $record['wind']['speed'] ?? null,
            'wind_deg' => $record['wind']['deg'] ?? null,
            'wind_gust' => $record['wind']['gust'] ?? null,
            'rain_1h' => $record['rain']['1h'] ?? null,
            'snow_1h' => $record['snow']['1h'] ?? null,
            'condition' => $record['weather'][0]['main'] ?? null,
            'description' => $record['weather'][0]['description'] ?? null,
            'icon' => $record['weather'][0]['icon'] ?? null,
        ];
    }
}
