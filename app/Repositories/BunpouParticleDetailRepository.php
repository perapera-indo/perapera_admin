<?php

namespace App\Repositories;

use App\Models\BunpouParticleDetail;

class BunpouParticleDetailRepository
{
    public function create($data)
    {
        $detail = new BunpouParticleDetail();

        $detail->sentence_romaji = $data['sentence_romaji'];
        $detail->sentence_jpn = $data['sentence_jpn'];
        $detail->particle = $data['particle'];
        $detail->sentence_idn = $data['sentence_idn'];
        $detail->sentence_description = $data['sentence_description'];
        $detail->formula = $data['formula'];
        $detail->order = $data['order'];

        if (!empty($data['sentence_img'])) {
            $uploadImage = upload_file($data['sentence_img'], 'uploads/bunpou/particle/detail/images/', 'image');
            $detail->sentence_img = $uploadImage['original'];
        }

        $detail->save();

        return $detail;
    }

    public function update($data, $id)
    {
        $detail = BunpouParticleDetail::find($id);

        if(array_key_exists("sentence_romaji",$data)){
            $detail->sentence_romaji = $data['sentence_romaji'];
        }

        if(array_key_exists("sentence_jpn",$data)){
            $detail->sentence_jpn = $data['sentence_jpn'];
        }

        if(array_key_exists("particle",$data)){
            $detail->particle = $data['particle'];
        }

        if(array_key_exists("sentence_idn",$data)){
            $detail->sentence_idn = $data['sentence_idn'];
        }

        if(array_key_exists("sentence_description",$data)){
            $detail->sentence_description = $data['sentence_description'];
        }

        if(array_key_exists("formula",$data)){
            $detail->formula = $data['formula'];
        }

        if(array_key_exists("order",$data)){
            $detail->order = $data['order'];
        }

        if(array_key_exists("sentence_img",$data)){
            @delete_file($data->image);
            $uploadImage = upload_file($data['sentence_img'], 'uploads/bunpou/particle/detail/images/', 'image');
            $detail->sentence_img = $uploadImage['original'];
        }

        return $detail->update();
    }

    public function delete($id)
    {
        $detail = BunpouParticleDetail::findOrFail($id);
        $detail->delete();

        return $detail;
    }

    public function activate($id)
    {
        $detail = BunpouParticleDetail::findOrFail($id);
        $detail->is_active = true;
        $detail->update();

        return $detail;
    }

    public function deactivate($id)
    {
        $detail = BunpouParticleDetail::findOrFail($id);
        $detail->is_active = false;
        $detail->update();

        return $detail;
    }
}
