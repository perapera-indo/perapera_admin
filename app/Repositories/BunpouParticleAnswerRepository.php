<?php

namespace App\Repositories;

use App\Models\BunpouParticleAnswer;

class BunpouParticleAnswerRepository
{
    public function create($data)
    {
        foreach($data['answer'] as $k => $v){
            $answer = new BunpouParticleAnswer();

            $answer->question = $data['question'];
            $answer->answer = $v['answer'];
            $answer->order = $k + 1;
            $answer->is_true = (array_key_exists("is_true",$v)) ? $v['is_true'] : false;

            if (array_key_exists("image",$v)) {
                $uploadImage = upload_file($v['image'], 'uploads/bunpou/vocab/images/', 'image');
                $answer->image = $uploadImage['original'];
            }

            if (array_key_exists("audio",$v)) {
                $uploadAudio = upload_file($v['audio'], 'uploads/bunpou/vocab/audios/', 'audio');
                $answer->audio = $uploadAudio['original'];
            }

            $answer->save();
        }

        return $answer;
    }

    public function update($data, $id)
    {
        foreach($data['answer'] as $k => $v){
            $answer = BunpouParticleAnswer::find($v['id']);

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
                $uploadImage = upload_file($v['image'], 'uploads/bunpou/vocab/images/', 'image');
                $answer->image = $uploadImage['original'];
            }

            if(array_key_exists("audio",$v)){
                $uploadAudio = upload_file($v['audio'], 'uploads/bunpou/vocab/audios/', 'audio');
                $answer->audio = $uploadAudio['original'];
            }

            $answer->update();
        }

        return $answer;
    }

    public function delete($id)
    {
        $answer = BunpouParticleAnswer::where("question",$id);
        $answer->delete();

        return $answer;
    }

    public function activate($id)
    {
        $answer = BunpouParticleAnswer::findOrFail($id);
        $answer->is_active = true;
        $answer->update();

        return $answer;
    }

    public function deactivate($id)
    {
        $answer = BunpouParticleAnswer::findOrFail($id);
        $answer->is_active = false;
        $answer->update();

        return $answer;
    }
}
