<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrCreateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:30',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|numeric|min:0',
            'categories' => 'required|array|min:2|max:10',
            'categories.*' => 'required|numeric|exists:categories,id'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
