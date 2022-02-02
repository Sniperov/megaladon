<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
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
            'category' => ['nullable', 'integer', 'exists:order_categories,id'],
            'status' => ['nullable', 'array'],
            'status.*' => ['required_with:status', 'integer'],
            'startRow' => ['nullable', 'integer'],
            'rowsPerPage' => ['nullable', 'integer']
        ];
    }
}
