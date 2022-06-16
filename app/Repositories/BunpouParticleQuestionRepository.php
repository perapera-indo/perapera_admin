<?php

namespace App\Repositories;

use App\Models\BunpouParticleQuestion;

class BunpouParticleQuestionRepository
{
    public function create($data)
    {
        $question = new BunpouParticleQuestion();

        $question->question = $data['question'];
        $question->test = $data['test'];
        $question->order = $data['order'];
        $question->time = $data['time'];

        if (!empty($data['question-image'])) {
            $uploadImage = upload_file($data['question-image'], 'uploads/bunpou/particle/images/', 'image');
            $question->image = $uploadImage['original'];
        }

        if (!empty($data['question-audio'])) {
            $uploadAudio = upload_file($data['question-audio'], 'uploads/bunpou/particle/audios/', 'audio');
            $question->audio = $uploadAudio['original'];
        }

        $question->save();

        return $question;
    }

    public function update($data, $id)
    {
        $question = BunpouParticleQuestion::find($id);

        if(array_key_exists("time",$data)){
            $question->time = $data['time'];
        }

        if(array_key_exists("question",$data)){
            $question->question = $data['question'];
        }

        if(array_key_exists("order",$data)){
            $question->order = $data['order'];
        }

        if(array_key_exists("test",$data)){
            $question->test = $data['test'];
        }

        if(array_key_exists("question-image",$data)){
            @delete_file($data->image);
            $uploadImage = upload_file($data['question-image'], 'uploads/bunpou/particle/images/', 'image');
            $question->image = $uploadImage['original'];
        }

        if(array_key_exists("question-audio",$data)){
            @delete_file($data->audio);
            $uploadAudio = upload_file($data['question-audio'], 'uploads/bunpou/particle/audios/', 'audio');
            $question->audio = $uploadAudio['original'];
        }

        return $question->update();
    }

    public function delete($id)
    {
        $question = BunpouParticleQuestion::findOrFail($id);
        $question->delete();

        return $question;
    }

    public function activate($id)
    {
        $question = BunpouParticleQuestion::findOrFail($id);
        $question->is_active = true;
        $question->update();

        return $question;
    }

    public function deactivate($id)
    {
        $question = BunpouParticleQuestion::findOrFail($id);
        $question->is_active = false;
        $question->update();

        return $question;
    }
}
