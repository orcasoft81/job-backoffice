<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class companyUpdateRequest extends FormRequest
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
            'name'=>'required|string|max:255|unique:job_categories,name,'.$this->route('job_category'),
            'address'=>'required|string|max:500',
            'industry'=>'required|string|max:255',
            'website'=>'nullable|url|max:255',
            'owner_password'=>'nullable|string|min:8|confirmed',
            'owner_name'=>'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'=>'The category name is required.',
            'name.string'=>'The category name must be a string.',
            'name.max'=>'The category name may not be greater than 255 characters.',
            'name.unique'=>'The category name has already been taken.',
            'description.string'=>'The description must be a string.',
            'address.required'=>'The address is required.',
            'address.string'=>'The address must be a string.',
            'address.max'=>'The address may not be greater than 500 characters.',
            'industry.required'=>'The industry is required.',
            'industry.email'=>'The industry must be a valid email address.',
            'industry.max'=>'The industry may not be greater than 255 characters.',
            'website.url'=>'The website must be a valid URL.',
            'website.max'=>'The website may not be greater than 255 characters.',
            'owner_password.string'=>'The owner password must be a string.',
            'owner_password.min'=>'The owner password must be at least 8 characters.',
            'owner_password.confirmed'=>'The owner password confirmation does not match.',
            'owner_name.required'=>'The owner name is required.',
            'owner_name.string'=>'The owner name must be a string.',
            'owner_name.max'=>'The owner name may not be greater than 255 characters.',
        ];
    }   
}
