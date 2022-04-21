<?php

namespace App\Repositories;

use App\Models\PatternLesson;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PatternLessonRepository
{
    public function create($data)
    {

        $lesson = new PatternLesson();
        $lesson->code = Str::random(10);
        $lesson->name = $data['name'];
        $lesson->pattern_chapter_id = $data['pattern_chapter_id'];
        $lesson->is_active = $data['is_active'];
        $lesson->save();

        return $lesson;
    }

    public function update($data, $id)
    {
        $lesson = PatternLesson::find($id);
        $lesson->name = $data['name'];
        $lesson->pattern_chapter_id = $data['pattern_chapter_id'];
        $lesson->is_active = $data['is_active'];
        $lesson->update();

        return $lesson;
    }
}
