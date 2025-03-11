<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
                Rule::unique('products', 'name')->ignore($this->route('product'))
            ],
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'color_id' => 'required',
            'size_id' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'desc' => 'required|max:5000',
            'thumbnail' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
            'first_image' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
            'second_image' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
            'third_image' => 'image|mimes:png,jpg,jpeg,webp|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'color_id.required' => 'The color Field is Required',
            'size_id.required' => 'The Size Field is Required',
            'brand_id.required' => 'The Brand Field is Required',
            'category_id.required' => 'The Category Field is Required',
            'desc.required' => 'The Descreption Field is Required',
            'desc.max' => 'The Descreption field must not greater than :max characters',
            'qty.required' => 'The Quantity Field is Required',
            'thumbnail.max' => 'The Thumbnail must not greater than 2MB',
            'thumbnail.image' => 'The Thumbnail must Be An Image',
            'first_image.max' => 'The First Image must not greater than 2MB',
            'first_image.image' => 'The First Image must Be An Image',
            'second_image.max' => 'The Second Image must not greater than 2MB',
            'second_image.image' => 'The  Second Image must Be An Image',
            'third_image.max' => 'The Third Image must not greater than 2MB',
            'third_image.image' => 'TheThird Image must Be An Image',

        ];
    }
}
