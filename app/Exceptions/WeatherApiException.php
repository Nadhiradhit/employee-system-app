<?php

namespace App\Exceptions;

use Illuminate\Http\Client\Response;

class WeatherApiException extends \RuntimeException
{
    public static function fromResponse(Response $response): self
    {
        $body = $response->json();
        $code = $body['cod'] ?? $response->status();
        $message = $body['message'] ?? 'Unknown weather API error';

        return match ((int) $code) {
            400 => new self("Invalid weather request: {$message}"),
            401 => new self("Weather API key rejected — check subscription tier, not just key validity."),
            404 => new self("No weather data available for these coordinates."),
            429 => new self("Weather API daily quota exceeded."),
            default => new self("Weather API error ({$code}): {$message}"),
        };
    }
}
