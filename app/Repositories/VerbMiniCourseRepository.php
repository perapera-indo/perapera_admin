<?php

namespace App\Repositories;

use App\Models\VerbMiniCourse;
use Illuminate\Support\Str;

class VerbMiniCourseRepository
{
    public function create($data)
    {

        $change = new VerbMiniCourse();

        $change->code = Str::random(15);
        $change->title = $data['title'];
        $change->master_verb_level_id = $data['master_verb_level_id'];
        $change->is_active = $data["is_active"];
        $change->save();

        return $change;
    }

    public function update($data, $id)
    {
        $change = VerbMiniCourse::find($id);

        $change->title = $data['title'];
        $change->master_verb_level_id = $data['master_verb_level_id'];
        $change->is_active = $data['is_active'];
        $change->update();

        return $change;
    }

    public function updateQuestion($data, $id)
    {
        $change = VerbMiniCourse::find($id);

        $change->question_count = $data['question_count'];
        $change->update();

        return $change;
    }
}
