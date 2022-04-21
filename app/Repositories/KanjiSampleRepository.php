<?php

namespace App\Repositories;

use App\Models\KanjiSample;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class KanjiSampleRepository
{
    public function create($data)
    {

        $sample = new KanjiSample();
        $sample->code = Str::random(15);
        $sample->sample_kanji = $data['sample_kanji'];
        $sample->sample_hiragana = $data['sample_hiragana'];
        $sample->sample_idn = $data['sample_idn'];
        $sample->kanji_education_id = $data['kanji_education_id'];
        $sample->is_active = $data['is_active'];
        $sample->save();

        return $sample;
    }

    public function update($data, $id)
    {
        $sample = KanjiSample::find($id);
        $sample->sample_kanji = $data['sample_kanji'];
        $sample->sample_hiragana = $data['sample_hiragana'];
        $sample->sample_idn = $data['sample_idn'];
        $sample->kanji_education_id = $data['kanji_education_id'];
        $sample->is_active = $data['is_active'];
        $sample->update();

        return $sample;
    }
}
