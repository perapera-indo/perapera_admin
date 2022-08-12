<?php

namespace App\Repositories;

use App\Models\Suuji;

class SuujiIntroRepository
{
    public function create($data)
    {
        $suuji = new Suuji();

        $suuji->room = $data['room'];
        $suuji->page = $data['page'];

        $suuji->save();

        return $suuji;
    }

    public function update($id,$data)
    {
        $suuji = Suuji::find($id);

        $suuji->room = $data['room'];
        $suuji->page = $data['page'];

        $suuji->update();

        return $suuji;
    }

    public function delete($id)
    {
        $suuji = Suuji::findOrFail($id);
        $suuji->delete();

        return $suuji;
    }
}
