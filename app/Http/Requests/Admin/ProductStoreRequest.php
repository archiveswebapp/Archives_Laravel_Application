<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255','unique:products,name,'.$this->product?->id],
            'price'       => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','max:2048'],
            'category_id' => ['required','exists:categories,id'],
            'stock' => ['required','integer','min:0'],


        ];
    }
}
