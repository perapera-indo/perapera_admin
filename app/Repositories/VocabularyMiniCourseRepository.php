<?php

namespace App\Repositories;

use App\Models\VocabularyMiniCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class VocabularyMiniCourseRepository
{
    public function create($data)
    {

        $course = new VocabularyMiniCourse();
        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->vocabulary_chapter_id = $data['vocabulary_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->test_time = $data['test_time'];
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $course = VocabularyMiniCourse::find($id);
        $course->title = $data['title'];
        $course->vocabulary_chapter_id = $data['vocabulary_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->test_time = $data['test_time'];
        $course->update();

        return $course;
    }
}
