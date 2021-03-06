<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AbilityCourseRequest extends FormRequest
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
            'title' => 'required|unique:ability_courses,title',
            'ability_course_chapter_id' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator); // TODO: Change the autogenerated stub
    }
}
