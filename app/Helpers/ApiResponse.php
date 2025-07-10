<?php

namespace App\Helpers;

class ApiResponse
{
    static function sendResponse($data = [], $message = [], $code = 200)
    {
        $response = [
            'status' => $code,
            'msg' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }
}
