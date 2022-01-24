<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class IndexStoreRequest extends FormRequest
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
            'rowsPerPage' => ['nullable', 'integer'],
            'startRow' => ['nullable', 'integer'],
            'sortBy' => ['nullable', 'string'],
            'desc' => ['nullable', 'boolean'],
        ];
    }
}
