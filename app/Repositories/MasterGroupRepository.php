<?php

namespace App\Repositories;

use App\Models\Letter;
use App\Models\MasterGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class MasterGroupRepository
{
    public function create($data)
    {

        $groups = new MasterGroup();
        $groups->code = Str::random(10);
        $groups->name = $data['name'];
        $groups->is_active = 1;
        $groups->save();

        return $groups;
    }

    public function update($data, $id)
    {
        $groups = MasterGroup::find($id);
        $groups->name = $data['name'];
        $groups->is_active = $data['is_active'];
        $groups->update();

        return $groups;
    }
}
