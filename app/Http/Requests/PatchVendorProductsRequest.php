<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatchVendorProductsRequest extends FormRequest
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
            'stock' => ['required','array'],
            'stock.*' => ['required','integer','min:0'],
            'price' => ['required','array'],
            'price.*' => ['required','numeric','min:0.000001'],
            'productIds' => ['required','array'],
            'productIds.*' => ['required','integer','exists:products,id'],
        ];
    }
}
