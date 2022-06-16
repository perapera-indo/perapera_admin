<?php

namespace App\Repositories;

use App\Models\BunpouModuleTest;

class BunpouModuleTestRepository
{
    public function create($data)
    {
        $test = new BunpouModuleTest();

        $test->title = $data['title'];
        $test->module = $data['module'];
        $test->order = 0;
        $test->time = $data['time'];
        $test->is_active = false;

        $test->save();

        return $test;
    }

    public function update($data, $id)
    {
        $test = BunpouModuleTest::find($id);

        if(array_key_exists("title",$data)){
            $test->title = $data['title'];
        }

        if(array_key_exists("module",$data)){
            $test->module = $data['module'];
        }

        if(array_key_exists("is_active",$data)){
            $test->is_active = $data['is_active'];
        }

        if(array_key_exists("order",$data)){
            $test->order = $data['order'];
        }

        if(array_key_exists("time",$data)){
            $test->time = $data['time'];
        }

        if(array_key_exists("module",$data)){
            $test->module = $data['module'];
        }

        return $test->update();
    }

    public function delete($id)
    {
        $test = BunpouModuleTest::findOrFail($id);
        $test->delete();

        return $test;
    }

    public function activate($id)
    {
        $test = BunpouModuleTest::findOrFail($id);
        $test->is_active = true;
        $test->update();

        $this->deactiveAllExcept($test,$test->module,$id);

        return $test;
    }

    public function deactivate($id)
    {
        $test = BunpouModuleTest::findOrFail($id);
        $test->is_active = false;
        $test->update();

        return $test;
    }

    private function deactiveAllExcept($test,$module,$id){
        if($test){
            BunpouModuleTest::where("id","<>",$id)->where("module",$module)->update([
                "is_active" => false
            ]);
        }
    }
}
