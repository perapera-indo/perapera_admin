<?php

namespace App\Repositories;

use App\Models\course;
use App\Models\VocabularyCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class VocabularyCourseRepository
{
    public function create($data)
    {

        $course = new VocabularyCourse();
        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->is_active = $data['is_active'];
        $course->vocabulary_course_chapter_id = $data['vocabulary_course_chapter_id'];
        $course->test_time = $data['test_time'];
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $course = VocabularyCourse::find($id);
        $course->title = $data['title'];
        $course->is_active = $data['is_active'];
        $course->vocabulary_course_chapter_id = $data['vocabulary_course_chapter_id'];
        $course->test_time = $data['test_time'];
        $course->update();

        return $course;
    }
}
