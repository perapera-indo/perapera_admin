<?php

namespace App\Repositories;

use App\Models\MasterAbilityCourseLevel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class MasterAbilityCourseLevelRepository
{
    public function create($data)
    {

        $course = new MasterAbilityCourseLevel();
        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->icon = $data['icon'];
        $course->is_active = 1;
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $course = MasterAbilityCourseLevel::find($id);
        $course->title = $data['title'];
        $course->icon = $data['icon'];
        $course->is_active = $data['is_active'];
        $course->update();

        return $course;
    }
}
