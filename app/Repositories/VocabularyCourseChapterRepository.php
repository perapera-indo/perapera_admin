<?php

namespace App\Repositories;

use App\Models\course;
use App\Models\VocabularyCourseChapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class VocabularyCourseChapterRepository
{
    public function create($data)
    {

        $course = new VocabularyCourseChapter();
        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->is_active = $data['is_active'];
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $course = VocabularyCourseChapter::find($id);
        $course->title = $data['title'];
        $course->is_active = $data['is_active'];
        $course->update();

        return $course;
    }
}
