<?php

namespace App\Repositories;

use App\Models\VerbChange;
use Illuminate\Support\Str;

class VerbChangeRepository
{
    public function create($data)
    {

        $change = new VerbChange();

        $change->code = Str::random(15);
        $change->name = $data['name'];
        // $change->word_jpn = $data['word_jpn'];
        // $change->word_romanji = $data['word_romanji'];
        // $change->word_romanji_highlight = $data['word_romanji_highlight'];
        // $change->sentence_jpn_highlight = $data['sentence_jpn_highlight'];
        // $change->word_idn = $data['word_idn'];
        // $change->type_idn = $data['type_idn'];
        // $change->type_jpn = $data['type_jpn'];
        $change->sentence_html = $data['sentence_html'];
        $change->master_verb_word_id = $data['master_verb_word_id'];
        $change->is_active = $data["is_active"];
        $change->save();

        return $change;
    }

    public function update($data, $id)
    {
        $change = VerbChange::find($id);

        $change->name = $data['name'];
        // $change->word_jpn = $data['word_jpn'];
        // $change->word_romanji = $data['word_romanji'];
        // $change->word_romanji_highlight = $data['word_romanji_highlight'];
        // $change->sentence_jpn_highlight = $data['sentence_jpn_highlight'];
        // $change->word_idn = $data['word_idn'];
        // $change->type_idn = $data['type_idn'];
        // $change->type_jpn = $data['type_jpn'];
        $change->sentence_html = $data['sentence_html'];
        $change->master_verb_word_id = $data['master_verb_word_id'];
        $change->is_active = $data['is_active'];
        $change->update();

        return $change;
    }
}
