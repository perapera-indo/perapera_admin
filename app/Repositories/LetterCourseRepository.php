<?php

namespace App\Repositories;

use App\Models\Letter;
use App\Models\LetterCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class LetterCourseRepository
{
    public function create($data)
    {

        $letter = new LetterCourse();
        $letter->code = Str::random(10);
        $letter->title = $data['title'];
        $letter->letter_category_id = $data['letter_category_id'];
        $letter->is_active = $data['is_active'];
        $letter->test_time = $data['test_time'];
        $letter->save();

        return $letter;
    }

    public function updateLetter($data, $id)
    {
        $letter = LetterCourse::find($id);
        $letter->title = $data['title'];
        $letter->letter_category_id = $data['letter_category_id'];
        $letter->is_active = $data['is_active'];
        $letter->test_time = $data['test_time'];
        $letter->update();

        return $letter;
    }
}
