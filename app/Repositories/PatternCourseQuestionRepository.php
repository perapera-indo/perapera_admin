<?php

namespace App\Repositories;

use App\Models\PatternCourseQuestion;
use App\Models\PatternCourse;
use App\Models\PatternCourseAnswer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PatternCourseQuestionRepository
{
    public function createNew($data)
    {

        $question = new PatternCourseQuestion;

        $question->code = Str::random(15);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];
        $question->pattern_course_id = $data['pattern_course_id'];
        $question->is_active = $data["is_active"];
        $question->save();

        $qid = $question->id;

        foreach ($data['answer'] as $value) {
            $answer = new PatternCourseAnswer;
            $answer->code = Str::random(15);
            $answer->pattern_course_question_id = $qid;
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;
            $answer->save();
        }

        if ($data["is_active"] == 1) {
            $course = PatternCourse::where('id',  $data['pattern_course_id'])->first();
            $course->question_count = $course->question_count + 1;

            $course->update();
        }

        return $question;
    }

    public function update($data, $id)
    {

        $question = PatternCourseQuestion::find($id);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];


        if ($question->is_active != $data['is_active']) {
            if ($data['is_active'] == 1) {
                $newcourse = PatternCourse::where('id', $question->pattern_course_id)->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            } else {
                $oldcourse = PatternCourse::where('id', $question->pattern_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();
            }
        }

        if ($question->pattern_course_id != $data['pattern_course_id']) {
            if ($data['is_active'] == 1) {
                $oldcourse = PatternCourse::where('id', $question->pattern_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();

                $newcourse = PatternCourse::where('id', $data['pattern_course_id'])->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            }
        }
        $question->pattern_course_id = $data['pattern_course_id'];
        $question->is_active = $data['is_active'];
        $question->update();

        foreach ($data['answer'] as $value) {
            $answer = PatternCourseAnswer::find($value["id"]);
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;

            $answer->update();
        }

        return $question;
    }
}
