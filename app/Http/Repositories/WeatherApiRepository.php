<?php

namespace App\Http\Repositories;

use App\Exceptions\WeatherApiException;
use Illuminate\Support\Facades\Http;

class WeatherApiRepository
{
    private readonly string $baseUrl;
    private readonly string $apiKey;

    public function __construct(
        ?string $baseUrl = null,
        ?string $apiKey = null,
    ) {
        $this->baseUrl = $baseUrl ?? config('services.openweather.base_url');
        $this->apiKey = $apiKey ?? config('services.openweather.key');
    }


    public function getWeatherData(float $lat, float $lon, array $extra = []): array
    {
        $response = Http::timeout(10)
            ->retry(2, 200)
            ->get("{$this->baseUrl}/weather", array_merge([
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $this->apiKey,
            ], $extra));

        if ($response->failed()) {
            throw WeatherApiException::fromResponse($response);
        }

        return $response->json();
    }
}
