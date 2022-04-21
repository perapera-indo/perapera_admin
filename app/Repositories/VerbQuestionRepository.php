<?php

namespace App\Repositories;

use App\Models\VerbCourseQuestion;
use App\Models\VerbCourse;
use App\Models\VerbCourseAnswer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VerbQuestionRepository
{
    public function createNew($data)
    {

        $question = new VerbCourseQuestion;

        $question->code = Str::random(15);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];
        $question->verb_course_id = $data['verb_course_id'];
        $question->is_active = $data["is_active"];
        $question->save();

        $qid = $question->id;

        foreach ($data['answer'] as $value) {
            $answer = new VerbCourseAnswer;
            $answer->code = Str::random(15);
            $answer->verb_course_question_id = $qid;
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;
            $answer->save();
        }

        if ($data['is_active'] == 1) {
            $course = VerbCourse::where('id', $data['verb_course_id'])->first();
            $course->question_count = $course->question_count + 1;

            $course->update();
        }

        return $question;
    }

    public function updateLetter($data, $id)
    {

        $question = VerbCourseQuestion::find($id);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];


        if ($question->is_active != $data['is_active']) {
            if ($data['is_active'] == 1) {
                $newcourse = VerbCourse::where('id', $question->verb_course_id)->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            } else {
                $oldcourse = VerbCourse::where('id', $question->verb_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();
            }
        }

        if ($question->verb_course_id != $data['verb_course_id']) {
            if ($data['is_active'] == 1) {
                $oldcourse = VerbCourse::where('id', $question->verb_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();

                $newcourse = VerbCourse::where('id', $data['verb_course_id'])->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            }
        }

        $question->verb_course_id = $data['verb_course_id'];
        $question->is_active = $data['is_active'];
        $question->update();

        foreach ($data['answer'] as $value) {
            $answer = VerbCourseAnswer::find($value["id"]);
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;

            $answer->update();
        }

        return $question;
    }
}
