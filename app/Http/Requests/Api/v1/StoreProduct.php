<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'name' => 'sometimes|unique:products,name',
                'regular_price' => 'sometimes|regex:/^\d+(\.\d{1,2})?$/',
                'is_for_sale' => 'sometimes|boolean',
                'available_stock' => 'sometimes|integer'
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => $validator->errors()
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
