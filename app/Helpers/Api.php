<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class Api
{
    public static function response($data, string $message, int $statusCode = Response::HTTP_OK, array $meta = [], $status = 'success')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'meta' => array_merge(['code' => $statusCode], $meta)
        ], $statusCode);
    }

    // public static function error(string $message, int $statusCode = 500, $data = null, array $meta = [])
    // {
    //     return response()->json([
    //         'status' => 'error',
    //         'message' => $message,
    //         'data' => $data,
    //         'meta' => array_merge(['code' => $statusCode], $meta)
    //     ], $statusCode);
    // }
}
