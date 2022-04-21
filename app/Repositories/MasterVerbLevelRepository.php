<?php

namespace App\Repositories;

use App\Models\Letter;
use App\Models\LetterCategory;
use App\Models\MasterVerbLevel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class MasterVerbLevelRepository
{
    public function create($data)
    {

        $level = new MasterVerbLevel();
        $level->code = Str::random(10);
        $level->name = $data['name'];
        $level->is_active = 1;
        $level->save();

        return $level;
    }

    public function update($data, $id)
    {
        $level = MasterVerbLevel::find($id);
        $level->name = $data['name'];
        $level->is_active = $data['is_active'];
        $level->update();

        return $level;
    }
}
