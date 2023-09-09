<?php

namespace App\traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\http\Exceptions\HttpResponseExcaption;

trait ErrorResponseJson
{
    protected function failedFalidation(Validator $validator)
    {
        throw new HttpResponseExcaption(
            response()->json([
                'meta' => [
                    'code' => 422,
                    'status' => 'error',
                    'message' => $validator->errors(),
                ],
                'data' => [],
            ], 422)
        );
    }
}
