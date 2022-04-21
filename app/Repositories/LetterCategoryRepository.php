<?php

namespace App\Repositories;

use App\Models\Letter;
use App\Models\LetterCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class LetterCategoryRepository
{
    public function create($data)
    {

        $letter = new LetterCategory();
        $letter->code = Str::random(10);
        $letter->name = $data['name'];
        $letter->is_active = 1;
        $letter->save();

        return $letter;
    }

    public function updateLetter($data, $id)
    {
        $letter = LetterCategory::find($id);
        $letter->name = $data['name'];
        $letter->is_active = $data['is_active'];
        $letter->update();

        return $letter;
    }
}
