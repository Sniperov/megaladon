<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'descrition' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:order_categories,id'],
            'price_recommended' => ['nullable', 'float'],
            'price_max' => ['nullable', 'float'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file'],
        ];
    }
}
