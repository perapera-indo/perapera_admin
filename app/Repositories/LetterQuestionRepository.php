<?php

namespace App\Repositories;

use App\Models\LetterCourseQuestion;
use App\Models\LetterCategory;
use App\Models\LetterCourse;
use App\Models\LetterCourseAnswer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LetterQuestionRepository
{
    public function createNew($data)
    {
        $question = new LetterCourseQuestion;

        $question->code = Str::random(15);
        $question->question = $data['question'];
        $question->letter_course_id = $data['letter_course_id'];
        $question->is_active = $data["is_active"];
        $question->image = $this->upload($data,"question-image",'uploads/images');
        $question->audio = $this->upload($data,"question-audio",'uploads/audios');
        $question->save();

        $qid = $question->id;

        foreach ($data['answer'] as $value) {
            $answer = new LetterCourseAnswer;
            $answer->code = Str::random(15);
            $answer->letter_course_question_id = $qid;
            $answer->answer = $value["answer"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;
            $answer->image = $this->upload($value,"image",'uploads/images');
            $answer->audio = $this->upload($value,"audio",'uploads/audios');
            $answer->save();
        }

        if ($question->is_active == 1) {
            $course = LetterCourse::where('id', request('letter_course_id'))->first();
            $course->question_count = $course->question_count + 1;

            $course->update();
        }

        return $question;
    }

    public function updateLetter($data, $id)
    {

        $question = LetterCourseQuestion::find($id);
        $question->question = $data['question'];


        if ($question->is_active != $data['is_active']) {
            if ($data['is_active'] == 1) {
                $newcourse = LetterCourse::where('id', $question->letter_course_id)->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            } else {
                $oldcourse = LetterCourse::where('id', $question->letter_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();
            }
        }

        if ($question->letter_course_id != $data['letter_course_id']) {
            if ($data['is_active'] == 1) {
                $oldcourse = LetterCourse::where('id', $question->letter_course_id)->first();
                $oldcourse->question_count = $oldcourse->question_count - 1;

                $oldcourse->update();


                $newcourse = LetterCourse::where('id', $data['letter_course_id'])->first();
                $newcourse->question_count = $newcourse->question_count + 1;

                $newcourse->update();
            }
        }

        $questionImage = $this->upload($data,"question-image",'uploads/images');
        if($questionImage!=null){
            $question->image = $questionImage;
        }

        $questionAudio = $this->upload($data,"question-audio",'uploads/audios');
        if($questionAudio!=null){
            $question->audio = $questionAudio;
        }

        $question->letter_course_id = $data['letter_course_id'];
        $question->is_active = $data['is_active'];

        $question->update();

        foreach ($data['answer'] as $value) {
            $answer = LetterCourseAnswer::find($value["id"]);
            $answer->answer = $value["answer"];
            $answer->is_true = isset($value["is_true"]) ? 1 : 0;

            $answerImage = $this->upload($value,"image",'uploads/images');
            if($answerImage!=null){
                $answer->image = $answerImage;
            }

            $answerAudio = $this->upload($value,"audio",'uploads/audios');
            if($answerAudio!=null){
                $answer->audio = $answerAudio;
            }

            $answer->update();
        }

        return $question;
    }

    private function upload($data,$key,$path){
        $dir = base_path("public/".$path);
        if ( !file_exists($dir) && !is_dir($dir) ) {
            mkdir($dir,0777);
        }

        if(!isset($data[$key]) || !$data[$key]){
            return null;
        }

        $file = uniqid() .".". $data[$key]->extension();
        $data[$key]->storeAs($path, $file,'public2');

        return $file;
    }
}
