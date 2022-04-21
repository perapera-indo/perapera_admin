<?php

namespace App\Repositories;

use App\Models\ParticleCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ParticleCourseRepository
{
    public function create($data)
    {

        $course = new ParticleCourse();
        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->particle_education_chapter_id = $data['particle_education_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->test_time = $data['test_time'];
        $course->save();

        return $course;
    }

    public function updatecourse($data, $id)
    {
        $course = ParticleCourse::find($id);
        $course->title = $data['title'];
        $course->particle_education_chapter_id = $data['particle_education_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->test_time = $data['test_time'];
        $course->update();

        return $course;
    }
}
