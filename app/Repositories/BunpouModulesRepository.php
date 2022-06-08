<?php

namespace App\Repositories;

use App\Models\BunpouModules;

class BunpouModulesRepository
{
    public function create($data)
    {
        $module = new BunpouModules();

        $module->name = $data['name'];
        $module->order = $data['order'];
        $module->is_active = true;

        $module->save();

        return $module;
    }

    public function update($data, $id)
    {
        $module = BunpouModules::find($id);

        if(array_key_exists("name",$data)){
            $module->name = $data['name'];
        }

        if(array_key_exists("is_active",$data)){
            $module->is_active = $data['is_active'];
        }

        if(array_key_exists("order",$data)){
            $module->order = $data['order'];
        }

        return $module->update();
    }

    public function delete($id)
    {
        $module = BunpouModules::findOrFail($id);
        $module->delete();

        return $module;
    }

    public function activate($id)
    {
        $module = BunpouModules::findOrFail($id);
        $module->is_active = true;
        $module->update();

        return $module;
    }

    public function deactivate($id)
    {
        $module = BunpouModules::findOrFail($id);
        $module->is_active = false;
        $module->update();

        return $module;
    }
}
