<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data, string $message, int $statusCode = 200, array $meta = [])
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'meta' => array_merge(['code' => $statusCode], $meta)
        ], $statusCode);
    }

    public static function error(string $message, int $statusCode = 500, $data = null, array $meta = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
            'meta' => array_merge(['code' => $statusCode], $meta)
        ], $statusCode);
    }
}
