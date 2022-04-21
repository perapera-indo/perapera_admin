<?php

namespace App\Repositories;

use App\Models\KanjiCourseQuestion;
use App\Models\KanjiCourse;
use App\Models\KanjiCourseAnswer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KanjiCourseQuestionRepository
{
    public function createNew($data)
    {

        $question = new KanjiCourseQuestion;

        $question->code = Str::random(15);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];
        $question->kanji_course_id = $data['kanji_course_id'];
        $question->is_active = $data["is_active"];
        $question->save();

        $qid = $question->id;

        foreach ($data['answer'] as $value) {
            $answer = new KanjiCourseAnswer;
            $answer->code = Str::random(15);
            $answer->kanji_course_question_id = $qid;
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;
            $answer->save();
        }

        if ($question->is_active == 1) {
            $course = KanjiCourse::where('id', request('kanji_course_id'))->first();
            $course->question_count = $course->question_count + 1;

            $course->update();
        }

        return $question;
    }

    public function update($data, $id)
    {

        $question = KanjiCourseQuestion::find($id);
        $question->question_jpn = $data['question_jpn'];
        $question->question_romanji = $data['question_romanji'];
        $question->question_idn = $data['question_idn'];

        if ($question->is_active != $data['is_active']) {
            if ($data['is_active'] == 1) {
                $newcourse = KanjiCourse::where('id', $question->kanji_course_id)->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            } else {
                $oldcourse = KanjiCourse::where('id', $question->kanji_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();
            }
        }

        if ($question->kanji_course_id != $data['kanji_course_id']) {
            if ($question->is_active == 1) {
                $oldcourse = KanjiCourse::where('id', $question->kanji_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();

                $newcourse = KanjiCourse::where('id', request('kanji_course_id'))->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            }
        }
        $question->kanji_course_id = $data['kanji_course_id'];
        $question->is_active = $data['is_active'];
        $question->update();

        foreach ($data['answer'] as $value) {
            $answer = KanjiCourseAnswer::find($value["id"]);
            $answer->answer_jpn = $value["answer_jpn"];
            $answer->answer_idn = $value["answer_idn"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;

            $answer->update();
        }

        return $question;
    }
}
