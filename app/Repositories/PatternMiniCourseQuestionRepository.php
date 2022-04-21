<?php

namespace App\Repositories;

use App\Models\PatternMiniCourseQuestion;
use App\Models\PatternMiniCourse;
use App\Models\PatternMiniCourseAnswer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatternMiniCourseQuestionRepository
{
    public function createNew($data)
    {

        $question = new PatternMiniCourseQuestion;

        $question->code = Str::random(15);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];
        $question->pattern_mini_course_id = $data['pattern_mini_course_id'];
        $question->is_active = isset($value["is_active"]);
        $question->save();

        $qid = $question->id;

        foreach ($data['answer'] as $value) {
            $answer = new PatternMiniCourseAnswer;
            $answer->code = Str::random(15);
            $answer->pattern_mini_course_question_id = $qid;
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;
            $answer->save();
        }

        if ($data["is_active"] == 1) {
            $course = PatternMiniCourse::where('id', $data['pattern_mini_course_id'])->first();
            $course->question_count = $course->question_count + 1;

            $course->update();
        }

        return $question;
    }

    public function update($data, $id)
    {

        $question = PatternMiniCourseQuestion::find($id);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];


        if ($question->is_active != $data['is_active']) {
            if ($data['is_active'] == 1) {
                $newcourse = PatternMiniCourse::where('id', $question->pattern_mini_course_id)->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            } else {
                $oldcourse = PatternMiniCourse::where('id', $question->pattern_mini_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();
            }
        }

        if ($question->pattern_mini_course_id != $data['pattern_mini_course_id']) {
            if ($data["is_active"] == 1) {
                $oldcourse = PatternMiniCourse::where('id', $question->pattern_mini_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();

                $newcourse = PatternMiniCourse::where('id', $data['pattern_mini_course_id'])->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            }
        }

        $question->pattern_mini_course_id = $data['pattern_mini_course_id'];
        $question->is_active = $data['is_active'];
        $question->update();

        foreach ($data['answer'] as $value) {
            $answer = PatternMiniCourseAnswer::find($value["id"]);
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;

            $answer->update();
        }

        return $question;
    }
}
