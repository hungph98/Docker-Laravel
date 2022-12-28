<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Throwable;

/**
 * 例外補足ハンドラ
 */
class Handler extends ExceptionHandler
{
    /**
     * アプリケーションの例外処理コールバックを登録します。
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * APIの実装外で起こった例外を補足する。
     * 認証失敗時はAPIに入る前に例外が発生してしまうため。
     *
     * @param $request HTTPリクエスト
     * @param Throwable $exception
     * @return エラーのレスポンス
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('ajax/*') || $request->is('api/*') || $request->ajax()) {
            return $this->createApiErrorResponse($exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * APIの実装外で起こった例外を拡張する。
     *
     * @param Throwable $exception 例外
     * @return Response HTTP レスポンス
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    private function createApiErrorResponse(Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            $status = $exception->getStatusCode();
            switch ($status) {
                case 400:
                    $errorMsg = 'Bad request.';
                    break;
                case 401:
                    $errorMsg = 'Unauthorized.';
                    break;
                case 404:
                    $errorMsg = 'Not found.';
                    break;
                default:
                    $status = 400;
                    $errorMsg = $exception->getMessage();
            }
        } else {
            if ($exception instanceof AuthorizationException) {
                $exception = $this->prepareException($this->mapException($exception));
                $status = $exception->getStatusCode();
            } else {
                $status = 500;
            }
            $errorMsg = $exception->getMessage();
        }
        $response = [
            'success' => 0,
            'errors' => [
                'error_code' => 'E0003',
                'error_message' => $errorMsg,
            ]
        ];
        return response()->json($response, $status);
    }
}
