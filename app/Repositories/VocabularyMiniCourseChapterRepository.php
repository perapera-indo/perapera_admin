<?php

namespace App\Repositories;

use App\Models\course;
use App\Models\VocabularyMiniCourseChapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class VocabularyMiniCourseChapterRepository
{
    public function create($data)
    {

        $course = new VocabularyMiniCourseChapter();
        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->vocabulary_chapter_id = $data['vocabulary_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $course = VocabularyMiniCourseChapter::find($id);
        $course->title = $data['title'];
        $course->vocabulary_chapter_id = $data['vocabulary_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->update();

        return $course;
    }
}
