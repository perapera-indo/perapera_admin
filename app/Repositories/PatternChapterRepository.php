<?php

namespace App\Repositories;

use App\Models\Letter;
use App\Models\PatternChapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PatternChapterRepository
{
    public function create($data)
    {

        $letter = new PatternChapter();
        $letter->code = Str::random(10);
        $letter->name = $data['name'];
        $letter->is_active = $data['is_active'];
        $letter->save();

        return $letter;
    }

    public function update($data, $id)
    {
        $letter = PatternChapter::find($id);
        $letter->name = $data['name'];
        $letter->is_active = $data['is_active'];
        $letter->update();

        return $letter;
    }
}
