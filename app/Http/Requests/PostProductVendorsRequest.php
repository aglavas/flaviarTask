<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostProductVendorsRequest extends FormRequest
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
            'stock' => ['required','integer'],
            'price' => ['required','numeric'],
            'vendor_id' => ['required','integer','exists:vendors,id', 'unique_with:product_vendor,product_id']
        ];
    }
}
