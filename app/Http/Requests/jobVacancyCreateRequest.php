<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class jobVacancyCreateRequest extends FormRequest
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
            'title'=>'required|string|max:255|unique:job_vacancies,title',
            'location'=>'required|string|max:255',
            'salary'=>'required|numeric|min:0',
            'type'=>'required|string|max:255',
            'description'=>'required|string|max:255',
            'jobCategoryId'=>'required|string|max:255',
            'companyId'=>'required|string|max:255',

        ];
    }
    public function messages(): array
    {
        return [
            'title.required'=>'The job title is required.',
            'title.string'=>'The job title must be a string.',
            'title.max'=>'The job title may not be greater than 255 characters.',
            'title.unique'=>'The job title has already been taken.',
            'location.required'=>'The location is required.',
            'location.string'=>'The location must be a string.',
            'location.max'=>'The location may not be greater than 255 characters.',
            'salary.required'=>'The salary is required.',
            'salary.numeric'=>'The salary must be a number.',
            'salary.min'=>'The salary must be at least 0.',
            'type.required'=>'The job type is required.',
            'type.string'=>'The job type must be a string.',
            'type.max'=>'The job type may not be greater than 255 characters.',
            'description.required'=>'The job description is required.',
            'description.string'=>'The job description must be a string.',
            'description.max'=>'The job description may not be greater than 255 characters.',
            'jobCategoryId.required'=>'The job category is required.',
            'jobCategoryId.string'=>'The job category must be a string.',
            'jobCategoryId.max'=>'The job category may not be greater than 255 characters.',
            'companyId.required'=>'The company is required.',
            'companyId.string'=>'The company must be a string.',
            'companyId.max'=>'The company may not be greater than 255 characters.',   
        ];
    }
}
