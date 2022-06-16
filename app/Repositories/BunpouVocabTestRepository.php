<?php

namespace App\Repositories;

use App\Models\BunpouVocabTest;

class BunpouVocabTestRepository
{
    public function create($data)
    {
        $test = new BunpouVocabTest();

        $test->title = $data['title'];
        $test->chapter = $data['chapter'];
        $test->order = 0;
        $test->time = $data['time'];
        $test->is_active = false;

        $test->save();

        return $test;
    }

    public function update($data, $id)
    {
        $test = BunpouVocabTest::find($id);

        if(array_key_exists("title",$data)){
            $test->title = $data['title'];
        }

        if(array_key_exists("chapter",$data)){
            $test->chapter = $data['chapter'];
        }

        if(array_key_exists("order",$data)){
            $test->order = $data['order'];
        }

        if(array_key_exists("time",$data)){
            $test->time = $data['time'];
        }

        return $test->update();
    }

    public function delete($id)
    {
        $test = BunpouVocabTest::findOrFail($id);
        $test->delete();

        return $test;
    }

    public function activate($id)
    {
        $test = BunpouVocabTest::findOrFail($id);
        $test->is_active = true;
        $test->update();

        $this->deactiveAllExcept($test,$test->chapter,$id);

        return $test;
    }

    public function deactivate($id)
    {
        $test = BunpouVocabTest::findOrFail($id);
        $test->is_active = false;
        $test->update();

        return $test;
    }

    private function deactiveAllExcept($test,$chapter,$id){
        if($test){
            BunpouVocabTest::where("id","<>",$id)->where("chapter",$chapter)->update([
                "is_active" => false
            ]);
        }
    }
}
