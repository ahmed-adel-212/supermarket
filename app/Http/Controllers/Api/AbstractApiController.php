<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbstractApiController extends Controller
{
    /**
     * For format succes response.
     *
     * @param $data
     * @param $message
     * @param $code
     * @return Response json 
     */
    public function sendResponse($data, $message = 'success', $code = 200)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($response, $code);
    }


    /**
     * For format error response.
     * 
     * @param $data
     * @param $message
     * @param $code
     * @return Response json 
     */
    public function sendError($message = 'error', $data=null, $code = 400)
    {
    	$response = [
            'success' => false,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }
}
