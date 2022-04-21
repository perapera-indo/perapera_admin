<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class VocabularyMiniCourseQuestionRequest extends FormRequest
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
            // "question_jpn" => 'required',
            // "question_romanji" => 'required',
            "question_idn" => 'required',
            'vocabulary_mini_course_id' => 'required',
            "answer" => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator); // TODO: Change the autogenerated stub
    }
}
