<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecutorRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'organization_type' => ['required', 'integer', 'exists:organization_types,id'],
            'organization_name' => ['required', 'string'],
            'bin' => ['nullable', 'string', 'min:12', 'max:12'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'lon' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
            'services.*' => ['required', 'integer', 'exists:services,id'],
        ];
    }
}
