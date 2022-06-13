<?php

namespace App\Repositories;

use App\Models\BunpouModuleAnswer;

class BunpouModuleAnswerRepository
{
    public function create($data)
    {
        foreach($data['answer'] as $k => $v){
            $answer = new BunpouModuleAnswer();

            $answer->question = $data['question'];
            $answer->answer = $v['answer'];
            $answer->order = $k + 1;
            $answer->is_true = (array_key_exists("is_true",$v)) ? $v['is_true'] : false;

            if (array_key_exists("image",$v)) {
                $uploadImage = upload_file($v['image'], 'uploads/bunpou/module/images/', 'image');
                $answer->image = $uploadImage['original'];
            }

            if (array_key_exists("audio",$v)) {
                $uploadAudio = upload_file($v['audio'], 'uploads/bunpou/module/audios/', 'audio');
                $answer->audio = $uploadAudio['original'];
            }

            $answer->save();
        }

        return $answer;
    }

    public function update($data, $id)
    {
        foreach($data['answer'] as $k => $v){
            $answer = BunpouModuleAnswer::find($v['id']);

            if(array_key_exists("answer",$v)){
                $answer->answer = $v['answer'];
            }

            $answer->is_true = false;
            if(array_key_exists("is_true",$v)){
                $answer->is_true = $v['is_true'];
            }

            if(array_key_exists("order",$v)){
                $answer->order = $v['order'];
            }

            if(array_key_exists("image",$v)){
                $uploadImage = upload_file($v['image'], 'uploads/bunpou/module/images/', 'image');
                $answer->image = $uploadImage['original'];
            }

            if(array_key_exists("audio",$v)){
                $uploadAudio = upload_file($v['audio'], 'uploads/bunpou/module/audios/', 'audio');
                $answer->audio = $uploadAudio['original'];
            }

            $answer->update();
        }

        return $answer;
    }

    public function delete($id)
    {
        $answer = BunpouModuleAnswer::where("question",$id);
        $answer->delete();

        return $answer;
    }

    public function activate($id)
    {
        $answer = BunpouModuleAnswer::findOrFail($id);
        $answer->is_active = true;
        $answer->update();

        return $answer;
    }

    public function deactivate($id)
    {
        $answer = BunpouModuleAnswer::findOrFail($id);
        $answer->is_active = false;
        $answer->update();

        return $answer;
    }
}
