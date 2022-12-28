<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Routing\Controller as BaseController;

abstract class HttpController extends BaseController
{
    /**
     * Create a new HttpController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Function reponseWithErrors
     *
     * @param $error
     * @param $httpCode
     * @param $errorCode
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function reponseWithErrors($error = null, $httpCode = 500, $errorCode = 'E0003', $message = null)
    {

        if (!$message) {
            $message = __("api." . $errorCode);
        }

        $response = [
            'success' => 0,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => $message
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data)
    {
        $response = ['success' => 1, 'data' => $data];

        return response()->json($response, 200);
    }

    /**
     * Function responseWithPagination
     *
     * @param $list
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithPagination($list)
    {
        $pagination = $list['meta']['pagination'];

        return response()->json([
            'success' => 1,
            'data' => [
                'total' => $pagination['total'],
                'count' => $pagination['count'],
                'per_page' => $pagination['per_page'],
                'current_page' => $pagination['current_page'],
                'total_pages' => $pagination['total_pages'],
                'list' => $list['data']
            ]
        ], 200);
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

        $response = ['success' => 1, 'message' => $message];

        return response()->json($response, 200);
    }
}
