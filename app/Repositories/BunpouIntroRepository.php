<?php

namespace App\Repositories;

use App\Models\Bunpou;

class BunpouIntroRepository
{
    public function create($data)
    {
        $bunpou = new Bunpou();

        $bunpou->room = $data['room'];
        $bunpou->page = $data['page'];

        $bunpou->save();

        return $bunpou;
    }

    public function update($id,$data)
    {
        $bunpou = Bunpou::find($id);

        $bunpou->room = $data['room'];
        $bunpou->page = $data['page'];

        $bunpou->update();

        return $bunpou;
    }

    public function delete($id)
    {
        $bunpou = Bunpou::findOrFail($id);
        $bunpou->delete();

        return $bunpou;
    }
}
