<?php

namespace App\Http\Requests\Auth;

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
            'type_id' => ['required', 'integer', 'exists:company_types,id'],
            'name' => ['required', 'string'],
            'bin' => ['nullable', 'string', 'min:12', 'max:12'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'lon' => ['required', 'numeric'],
            'lat' => ['required', 'numeric'],
            'full_address' => ['required', 'string', 'max:255'],
            'services.*' => ['required', 'integer', 'exists:service_types,id'],
        ];
    }
}
