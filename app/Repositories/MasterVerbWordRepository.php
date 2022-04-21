<?php

namespace App\Repositories;

use App\Models\MasterVerbGroup;
use App\Models\MasterVerbWord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MasterVerbWordRepository
{
    public function create($data)
    {

        $vGroup = MasterVerbGroup::find($data['master_verb_group_id']);
        $word = new MasterVerbWord();

        $word->code = Str::random(15);
        $word->name = $data['name'];
        $word->word_japan = $data['word_japan'];
        $word->word_romanji = $data['word_romanji'];
        $word->word_romanji_highlight = $data['word_romanji_highlight'];
        $word->word_idn = $data['word_idn'];
        $word->master_verb_group_id = $data['master_verb_group_id'];
        $word->master_verb_level_id = $vGroup->master_verb_level_id;
        $word->is_active = $data["is_active"];
        $word->save();

        return $word;
    }

    public function update($data, $id)
    {
        $vGroup = MasterVerbGroup::find($data['master_verb_group_id']);
        $word = MasterVerbWord::find($id);

        $word->name = $data['name'];
        $word->word_japan = $data['word_japan'];
        $word->word_romanji = $data['word_romanji'];
        $word->word_romanji_highlight = $data['word_romanji_highlight'];
        $word->word_idn = $data['word_idn'];
        $word->master_verb_group_id = $data['master_verb_group_id'];
        $word->master_verb_level_id = $vGroup->master_verb_level_id;
        $word->is_active = $data['is_active'];
        $word->update();

        return $word;
    }
}
