<?php

namespace App\Repositories;

use App\Models\BunpouChapters;

class BunpouChaptersRepository
{
    public function create($data)
    {
        $chapter = new BunpouChapters();

        $chapter->name = $data['name'];
        $chapter->module = $data['module'];
        $chapter->order = $data['order'];
        $chapter->is_active = true;

        $chapter->save();

        return $chapter;
    }

    public function update($data, $id)
    {
        $chapter = BunpouChapters::find($id);

        if(array_key_exists("name",$data)){
            $chapter->name = $data['name'];
        }

        if(array_key_exists("module",$data)){
            $chapter->module = $data['module'];
        }

        if(array_key_exists("is_active",$data)){
            $chapter->is_active = $data['is_active'];
        }

        if(array_key_exists("order",$data)){
            $chapter->order = $data['order'];
        }

        if(array_key_exists("module",$data)){
            $chapter->module = $data['module'];
        }

        return $chapter->update();
    }

    public function delete($id)
    {
        $chapter = BunpouChapters::findOrFail($id);
        $chapter->delete();

        return $chapter;
    }

    public function activate($id)
    {
        $chapter = BunpouChapters::findOrFail($id);
        $chapter->is_active = true;
        $chapter->update();

        return $chapter;
    }

    public function deactivate($id)
    {
        $chapter = BunpouChapters::findOrFail($id);
        $chapter->is_active = false;
        $chapter->update();

        return $chapter;
    }
}
