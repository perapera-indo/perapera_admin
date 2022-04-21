<?php

namespace App\Repositories;

use App\Models\PatternMiniCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PatternMiniCourseRepository
{
    public function create($data)
    {

        $course = new PatternMiniCourse();
        $course->code = Str::random(15);
        $course->title = $data['title'];
        $course->master_group_id = $data['master_group_id'];
        $course->test_time = $data['test_time'];
        $course->is_active = $data['is_active'];
        $course->save();

        return $course;
    }

    public function updatecourse($data, $id)
    {
        $course = PatternMiniCourse::find($id);
        $course->title = $data['title'];
        $course->master_group_id = $data['master_group_id'];
        $course->test_time = $data['test_time'];
        $course->is_active = $data['is_active'];
        $course->update();

        return $course;
    }
}
