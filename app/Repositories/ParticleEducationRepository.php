<?php

namespace App\Repositories;

use App\Models\ParticleEducation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ParticleEducationRepository
{
    public function create($data)
    {

        $education = new ParticleEducation();
        $education->code = Str::random(10);
        $education->title = $data['title'];
        $education->letter_jpn = $data['letter_jpn'];
        $education->letter_romanji = $data['letter_romanji'];
        $education->description = $data['description'];
        $education->particle_education_chapter_id = $data['particle_education_chapter_id'];
        $education->is_active = $data['is_active'];
        $education->save();

        return $education;
    }

    public function update($data, $id)
    {
        $education = ParticleEducation::find($id);
        $education->title = $data['title'];
        $education->letter_jpn = $data['letter_jpn'];
        $education->letter_romanji = $data['letter_romanji'];
        $education->description = $data['description'];
        $education->particle_education_chapter_id = $data['particle_education_chapter_id'];
        $education->is_active = $data['is_active'];
        $education->update();

        return $education;
    }
}
