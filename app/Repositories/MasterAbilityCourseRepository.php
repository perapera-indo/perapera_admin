<?php

namespace App\Repositories;

use App\Models\MasterAbilityCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class MasterAbilityCourseRepository
{
    public function create($data)
    {

        $course = new MasterAbilityCourse();
        $course->code = Str::random(10);
        $course->name = $data['name'];
        $course->learning_time = $data['learning_time'];
        $course->master_group_id = $data['master_group_id'];
        $course->is_active = 1;
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $course = MasterAbilityCourse::find($id);
        $course->name = $data['name'];
        $course->learning_time = $data['learning_time'];
        $course->master_group_id = $data['master_group_id'];
        $course->is_active = $data['is_active'];
        $course->update();

        return $course;
    }
}
