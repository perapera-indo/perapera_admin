<?php

namespace App\Repositories;

use App\Models\kanji;
use App\Models\KanjiMiniCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class KanjiMiniCourseRepository
{
    public function create($data)
    {

        $kanji = new KanjiMiniCourse();
        $kanji->code = Str::random(10);
        $kanji->title = $data['title'];
        $kanji->kanji_chapter_id = $data['kanji_chapter_id'];
        $kanji->test_time = $data['test_time'];
        $kanji->is_active = $data['is_active'];
        $kanji->save();

        return $kanji;
    }

    public function update($data, $id)
    {
        $kanji = KanjiMiniCourse::find($id);
        $kanji->title = $data['title'];
        $kanji->kanji_chapter_id = $data['kanji_chapter_id'];
        $kanji->test_time = $data['test_time'];
        $kanji->is_active = $data['is_active'];
        $kanji->update();

        return $kanji;
    }
}
