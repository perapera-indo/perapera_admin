<?php

namespace App\Repositories;

use App\Models\Vocabulary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VocabularyRepository
{
    public function create($data)
    {

        $word = new Vocabulary();

        $word->code = Str::random(15);
        $word->word_jpn = $data['word_jpn'];
        $word->word_romaji = $data['word_romaji'];
        $word->word_idn = $data['word_idn'];
        $word->vocabulary_chapter_id = $data['vocabulary_chapter_id'];
        $word->is_active = $data["is_active"];
        $word->save();

        return $word;
    }

    public function update($data, $id)
    {
        $word = Vocabulary::find($id);

        $word->word_jpn = $data['word_jpn'];
        $word->word_romaji = $data['word_romaji'];
        $word->word_idn = $data['word_idn'];
        $word->vocabulary_chapter_id = $data['vocabulary_chapter_id'];
        $word->is_active = $data['is_active'];
        $word->update();

        return $word;
    }
}
