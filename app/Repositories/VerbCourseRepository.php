<?php

namespace App\Repositories;

use App\Models\VerbCourse;
use Illuminate\Support\Str;

class VerbCourseRepository
{
    public function create($data)
    {

        $change = new VerbCourse();

        $change->code = Str::random(15);
        $change->title = $data['title'];
        $change->master_verb_level_id = $data['master_verb_level_id'];
        $change->is_active = $data["is_active"];
        $change->test_time = $data["test_time"];
        $change->save();

        return $change;
    }

    public function update($data, $id)
    {
        $change = VerbCourse::find($id);

        $change->title = $data['title'];
        $change->master_verb_level_id = $data['master_verb_level_id'];
        $change->is_active = $data['is_active'];
        $change->test_time = $data['test_time'];
        $change->update();

        return $change;
    }

    public function updateQuestion($data, $id)
    {
        $change = VerbCourse::find($id);

        $change->question_count = $data['question_count'];
        $change->update();

        return $change;
    }
}
