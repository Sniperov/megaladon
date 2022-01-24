<?php

namespace App\Http\Requests\Executor;

use Illuminate\Foundation\Http\FormRequest;

class ExecutorUpdateRequest extends FormRequest
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
            'type_id' => ['nullable', 'integer', 'exists:executor_service_types,id'],
            'name' => ['nullable', 'string'],
            'bin' => ['nullable', 'string'],
            'city_id' => ['nullable', 'integer', 'exists:cities,id'],
            'lat' => ['nullable', 'numeric'],
            'lon' => ['nullable', 'numeric'],
            'full_address' => ['nullable', 'string'],
        ];
    }
}
