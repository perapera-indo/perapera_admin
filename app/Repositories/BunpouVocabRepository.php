<?php

namespace App\Repositories;

use App\Models\BunpouVocab;

class BunpouVocabRepository
{
    public function create($data)
    {
        $vocab = new BunpouVocab();

        $vocab->word_jpn = $data['word_jpn'];
        $vocab->word_romaji = $data['word_romaji'];
        $vocab->word_idn = $data['word_idn'];
        $vocab->is_active = true;
        $vocab->chapter = $data['chapter'];
        $vocab->order = $data['order'];

        if (!empty($data['image'])) {
            $uploadImage = upload_file($data['image'], 'uploads/bunpou/vocab/images/', 'image');
            $vocab->image = $uploadImage['original'];
        }

        if (!empty($data['audio'])) {
            $uploadAudio = upload_file($data['audio'], 'uploads/bunpou/vocab/audios/', 'audio');
            $vocab->audio = $uploadAudio['original'];
        }

        $vocab->save();

        return $vocab;
    }

    public function update($id,$data)
    {
        $vocab = BunpouVocab::find($id);

        if(array_key_exists("word_jpn",$data)){
            $vocab->word_jpn = $data['word_jpn'];
        }

        if(array_key_exists("word_romaji",$data)){
            $vocab->word_romaji = $data['word_romaji'];
        }

        if(array_key_exists("word_idn",$data)){
            $vocab->word_idn = $data['word_idn'];
        }

        if(array_key_exists("is_active",$data)){
            $vocab->is_active = $data['is_active'];
        }

        if(array_key_exists("chapter",$data)){
            $vocab->chapter = $data['chapter'];
        }

        if(array_key_exists("order",$data)){
            $vocab->order = $data['order'];
        }

        if(array_key_exists("image",$data)){
            @delete_file($data->image);
            $uploadImage = upload_file($data['image'], 'uploads/bunpou/vocab/images/', 'image');
            $vocab->image = $uploadImage['original'];
        }

        if(array_key_exists("audio",$data)){
            @delete_file($data->audio);
            $uploadAudio = upload_file($data['audio'], 'uploads/bunpou/vocab/audios/', 'audio');
            $vocab->audio = $uploadAudio['original'];
        }

        return $vocab->update();
    }

    public function delete($id)
    {
        $vocab = BunpouVocab::findOrFail($id);
        $vocab->delete();

        return $vocab;
    }

    public function activate($id)
    {
        $vocab = BunpouVocab::findOrFail($id);
        $vocab->is_active = true;
        $vocab->update();

        return $vocab;
    }

    public function deactivate($id)
    {
        $vocab = BunpouVocab::findOrFail($id);
        $vocab->is_active = false;
        $vocab->update();

        return $vocab;
    }
}
