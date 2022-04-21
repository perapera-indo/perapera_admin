<?php

namespace App\Repositories;

use App\Models\AbilityCourseChapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class AbilityCourseChapterRepository
{
    public function create($data)
    {

        $chapter = new AbilityCourseChapter();
        $chapter->code = Str::random(10);
        $chapter->name = $data['name'];
        $chapter->master_group_id = $data['master_group_id'];
        $chapter->chapter_desc = $data['chapter_desc'];
        $chapter->is_active = $data['is_active'];
        $chapter->is_done_test = @$data['is_done_test'];
        $chapter->save();

        return $chapter;
    }

    public function update($data, $id)
    {
        $chapter = AbilityCourseChapter::find($id);
        $chapter->name = $data['name'];
        $chapter->master_group_id = $data['master_group_id'];
        $chapter->chapter_desc = $data['chapter_desc'];
        $chapter->is_active = $data['is_active'];
        $chapter->is_done_test = @$data['is_done_test'];
        $chapter->update();

        return $chapter;
    }
}
