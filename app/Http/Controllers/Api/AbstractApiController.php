<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbstractApiController extends Controller
{
    /**
     * success response method.
     *
     * @param $result array
     * @param $message string
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message = '', $code = 200)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @param erorr
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
            'data' => $errorMessages,
        ];

        return response()->json($response, $code);
    }
}
