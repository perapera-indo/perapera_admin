<?php

namespace App\Repositories;

use App\Models\ParticleEducationChapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ParticleEducationChapterRepository
{
    public function create($data)
    {

        $education = new ParticleEducationChapter();
        $education->code = Str::random(10);
        $education->title = $data['title'];
        $education->is_active = $data['is_active'];
        $education->save();

        return $education;
    }

    public function update($data, $id)
    {
        $education = ParticleEducationChapter::find($id);
        $education->title = $data['title'];
        $education->is_active = $data['is_active'];
        $education->update();

        return $education;
    }
}
