<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PlaceOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'items' => 'required|array',
            'items.*.medicine_id' => [
                'required',
                'exists:medicines,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                
                Rule::exists('medicines', 'id')->where(function ($query) {
                    $query->where('quantity', '>=', $this->input('items.*.quantity'));
                }),
            ],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422));
    }
}
