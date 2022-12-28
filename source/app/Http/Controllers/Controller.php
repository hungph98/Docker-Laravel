<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Exception;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Function reponseWithErrors
     *
     * @param $error
     * @param $httpCode
     * @param $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function reponseWithErrors($error = null, $httpCode = 500, $errorCode = 'E0003')
    {
        $response = [
            'success' => 0,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => __("api." . $errorCode)
                ]
        ];

        if ($error) {
            if ($error instanceof Exception) {
                $response['detail'] = $error->getMessage();
            } else {
                $response['detail'] = $error;
            }
        }

        return response()->json($response, $httpCode);
    }

    /**
     * Function responseSuccess
     *
     * @param $data
     * @param $httpCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data, $httpCode = 200)
    {
        $response = ['success' => true, 'data' => $data];

        return response()->json($response, $httpCode);
    }

    /**
     * Function responseOk
     *
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseOk($message = null)
    {
        if (!$message) {
            $message = __('message.system.ok');
        }
        $response = ['success' => true, 'data' => [], 'message' => $message];

        return response()->json($response, 200);
    }

    /**
     * Function responseError
     *
     * @param $data
     * @param $httpCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($data = [], $httpCode = 500)
    {
        $response = ['success' => false, 'data' => $data];
        return response()->json($response, $httpCode);
    }
}
