<?php

namespace App\Http\Controllers\web;

use App\Exceptions\WeatherApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\ShowWeatherRequest;
use App\Http\Services\WeatherApiService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function __construct(
        private WeatherApiService $weatherService
    ) {}

    public function show(ShowWeatherRequest $request): JsonResponse
    {
        try {
            $weather = $this->weatherService->getData(
                lat: (float) $request->validated('lat'),
                lon: (float) $request->validated('lon'),
            );

            return response()->json([
                'status' => true,
                'data' => $weather,
            ]);
        } catch (WeatherApiException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 502);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
