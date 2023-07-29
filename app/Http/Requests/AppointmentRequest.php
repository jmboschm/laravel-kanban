<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'start_time' => ['required'],
            'finish_time' => ['required'],
            'color' => ['required'],
            'user_id' => ['required'],

        ];
    }

    public function messages(): array
    {
        return [
            'start_time.required' => 'Debes rellenar este campo',
            'title.required' => 'Debes rellenar este campo',
            'finish_time.required' => 'Debes rellenar este campo',
            'color.required' => 'Debes rellenar este campo',
            'user_id.required' => 'Debes rellenar este campo',
        ];
    }
}
