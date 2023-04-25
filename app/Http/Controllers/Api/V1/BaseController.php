<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * success response method.
     * @result mixed the returned result
     * @message string
     * @responseCode \Illuminate\Http\Response
     *
     * @param $result
     * @param $message
     * @param int $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message, $responseCode = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];


        return response()->json($response, $responseCode);
    }


    /**
     * return error response.
     * @param string $error error message
     * @param array $errorMessages array of messages
     *
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $responseCode = Response::HTTP_BAD_REQUEST)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            if ($errorMessages instanceof MessageBag) {

                $errorMessages->add('error', $errorMessages->first());
                $response['message'] = $errorMessages->first(); //put the first error inside message
            }
            $response['data'] = $errorMessages;
        } else {
            $response['data'] = ['error' => "$error"];
        }


        return response()->json($response, $responseCode);
    }
}
