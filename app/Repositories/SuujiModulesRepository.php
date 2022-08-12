<?php

namespace App\Repositories;

use App\Models\SuujiModules;

class SuujiModulesRepository
{
    public function create($data)
    {
        $SuujiModules = new SuujiModules();

        if(array_key_exists("name",$data)){
            $SuujiModules->name = $data['name'];
        }

        if(array_key_exists("order",$data)){
            $SuujiModules->order = $data['order'];
        }

        $SuujiModules->save();

        return $SuujiModules;
    }

    public function update($id,$data)
    {
        $SuujiModules = SuujiModules::find($id);

        if(array_key_exists("name",$data)){
            $SuujiModules->name = $data['name'];
        }

        if(array_key_exists("order",$data)){
            $SuujiModules->order = $data['order'];
        }

        return $SuujiModules->update();
    }

    public function delete($id)
    {
        $SuujiModules = SuujiModules::findOrFail($id);
        $SuujiModules->delete();

        return $SuujiModules;
    }

    public function activate($id)
    {
        $SuujiModules = SuujiModules::findOrFail($id);
        $SuujiModules->is_active = true;
        $SuujiModules->update();

        return $SuujiModules;
    }

    public function deactivate($id)
    {
        $SuujiModules = SuujiModules::findOrFail($id);
        $SuujiModules->is_active = false;
        $SuujiModules->update();

        return $SuujiModules;
    }
}
