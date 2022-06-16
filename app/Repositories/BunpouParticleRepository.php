<?php

namespace App\Repositories;

use App\Models\BunpouParticle;

class BunpouParticleRepository
{
    public function create($data)
    {
        $particle = new BunpouParticle();

        $particle->letter_jpn = $data['letter_jpn'];
        $particle->letter_romaji = $data['letter_romaji'];
        $particle->title = $data['title'];
        $particle->is_active = true;
        $particle->chapter = $data['chapter'];
        $particle->order = $data['order'];
        $particle->description = $data['description'];

        $particle->save();

        return $particle;
    }

    public function update($id,$data)
    {
        $particle = BunpouParticle::find($id);

        if(array_key_exists("letter_jpn",$data)){
            $particle->letter_jpn = $data['letter_jpn'];
        }

        if(array_key_exists("letter_romaji",$data)){
            $particle->letter_romaji = $data['letter_romaji'];
        }

        if(array_key_exists("title",$data)){
            $particle->title = $data['title'];
        }

        if(array_key_exists("is_active",$data)){
            $particle->is_active = $data['is_active'];
        }

        if(array_key_exists("chapter",$data)){
            $particle->chapter = $data['chapter'];
        }

        if(array_key_exists("order",$data)){
            $particle->order = $data['order'];
        }

        if(array_key_exists("description",$data)){
            $particle->description = $data['description'];
        }

        return $particle->update();
    }

    public function delete($id)
    {
        $particle = BunpouParticle::findOrFail($id);
        $particle->delete();

        return $particle;
    }

    public function activate($id)
    {
        $particle = BunpouParticle::findOrFail($id);
        $particle->is_active = true;
        $particle->update();

        return $particle;
    }

    public function deactivate($id)
    {
        $particle = BunpouParticle::findOrFail($id);
        $particle->is_active = false;
        $particle->update();

        return $particle;
    }
}
