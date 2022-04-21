<?php

namespace App\Repositories;

use App\Models\kanji;
use App\Models\KanjiCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class KanjiCourseRepository
{
    public function create($data)
    {

        $kanji = new KanjiCourse();
        $kanji->code = Str::random(10);
        $kanji->title = $data['title'];
        // $kanji->kanji_category_id = $data['kanji_category_id'];
        $kanji->is_active = $data['is_active'];
        $kanji->save();

        return $kanji;
    }

    public function update($data, $id)
    {
        $kanji = KanjiCourse::find($id);
        $kanji->title = $data['title'];
        // $kanji->kanji_category_id = $data['kanji_category_id'];
        $kanji->is_active = $data['is_active'];
        $kanji->update();

        return $kanji;
    }
}
