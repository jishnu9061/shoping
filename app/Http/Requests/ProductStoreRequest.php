<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:products,code',
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'required|numeric|min:0',
        ];
    }
}
