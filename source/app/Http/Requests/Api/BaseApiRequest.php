<?php

namespace App\Http\Requests\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;

class BaseApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $validationErrors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'success' => 0,
            'errors' => [
                'error_code' => 'E0005',
                'error_message' => __("api.E0005"),
            ],
            'validationErrors' => $validationErrors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
