<?php

namespace App\Trait;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{

    public static function response(array $data, $status_code = Response::HTTP_OK, $headers = []): JsonResponse
    {
        return response()->json($data, $status_code, $headers);
    }

    // Success response (200).
    public static function successResponse($message = null, $data = null, int $status_code = Response::HTTP_OK, $headers = []): JsonResponse
    {
        $responseData = [
            'status' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => $status_code
        ];

        return static::response($responseData, $status_code, $headers);
    }

    // Created response (201).
    public static function createdResponse($message = null, $data = null, $headers = []): JsonResponse
    {
        return static::successResponse($message, $data, Response::HTTP_CREATED, $headers);
    }

    public static function errorResponse($message = null, $status_code = Response::HTTP_INTERNAL_SERVER_ERROR, $errors = null, $headers = []): JsonResponse
    {
        $responseData = [
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'status_code' => $status_code
        ];

        return static::response($responseData, $status_code, $headers);
    }

    // Not Found response (404).
    public static function notFoundResponse($message = 'Not Found.', $errors = null): JsonResponse
    {
        return static::errorResponse($message, Response::HTTP_NOT_FOUND, $errors);
    }

    // Unauthorized response (401).
    public static function unauthorizedResponse($message = 'Unauthorized.', $errors = null): JsonResponse
    {
        return static::errorResponse($message, Response::HTTP_UNAUTHORIZED, $errors);
    }

    // Forbidden response (403).
    public static function forbiddenResponse($message = 'You do not have permission to access this resource.', $errors = null): JsonResponse
    {
        return static::errorResponse($message, Response::HTTP_FORBIDDEN, $errors);
    }

    // Validation error response (422).
    public static function validationErrorResponse($errors = null, $message = 'Validation Error'): JsonResponse
    {
        return static::errorResponse($message, Response::HTTP_UNPROCESSABLE_ENTITY, $errors);
    }

    // Server error response (500).
    public static function serverErrorResponse($message = 'Internal Server Error', $errors = null): JsonResponse
    {
        return static::errorResponse($message, Response::HTTP_INTERNAL_SERVER_ERROR, $errors);
    }
}
