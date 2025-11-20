<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class jobApplicationUpdateRequest extends FormRequest
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
            'status'=>'bail|required|string|in:pending,accepted,rejected',

        ];
    }
    public function messages(): array
    {
        return [
            'status.required'=>'The status is required.',
            'status.in'=>'The selected status is invalid. Allowed values are: pending, accepted, rejected.',

        ];
    }   
}
