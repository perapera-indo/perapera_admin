<?php

namespace App\Repositories;

use App\Models\PatternLessonExample;
use App\Models\PatternLessonExampleJapan;
use App\Models\PatternLessonExampleRomanji;
use App\Models\PatternLessonFormula;
use App\Models\PatternLessonHighlight;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PatternLessonExampleRepository
{
    public function create($data)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 10 detik
            'timeout'  => 10,
        ]);

        $lesson = new PatternLessonExample();

        if (isset($data['img'])) { // for image color
            $image = base64_encode(file_get_contents($data['img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'examples',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);

            $lesson->img = $img_url->data->path;
        }

        $lesson->code = Str::random(10);
        $lesson->text_idn = $data['text_idn'];
        $lesson->pattern_lesson_detail_id = $data['pattern_lesson_detail_id'];
        $lesson->save();

        $lid = $lesson->id;

        if ($lid > 0) {
            foreach ($data['example_japans'] as $key => $value) {
                $exJapan = new PatternLessonExampleJapan();
                $exJapan->code = Str::random(15);
                $exJapan->pattern_lesson_example_id = $lid;
                $exJapan->text_kanji = $value['text_kanji'];
                $exJapan->text_idn = $value['text_idn'];
                $exJapan->text_hiragana = $value['text_hiragana'];
                $exJapan->is_highlighted = @$value['is_highlighted'] ? 1 : 0;
                $exJapan->save();
            }

            foreach ($data['example_romanjis'] as $value) {
                $exRomanji = new PatternLessonExampleRomanji();
                $exRomanji->code = Str::random(15);
                $exRomanji->pattern_lesson_example_id = $lid;
                $exRomanji->text = $value['text'];
                $exRomanji->is_highlighted = @$value['is_highlighted'] ? 1 : 0;
                $exRomanji->save();
            }
        }


        return $lesson;
    }

    public function update($data, $id, $did, $eid)
    {
        // nb : id -> lesson_id, did -> lesson_detail_id
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 10 detik
            'timeout'  => 10,
        ]);

        $lesson = PatternLessonExample::find($eid);
        if (isset($data['img'])) {
            $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $lesson->img);

            // for image
            $image = base64_encode(file_get_contents($data['img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'examples',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $lesson->img = $img_url->data->path;
        }


        $lesson->text_idn = $data['text_idn'];
        $lesson->update();

        $h_array = array();
        $f_array = array();
        foreach ($data['example_japans'] as $key => $value) {
            array_push($h_array, @$value['id']);
        }
        foreach ($data['example_romanjis'] as $key => $value) {
            array_push($f_array, @$value['id']);
        }


        // chceking delete old inexists data
        $ex = PatternLessonExampleJapan::where('pattern_lesson_example_id', $eid)
            ->whereNotIn('id', $h_array)->delete();

        $ex1 = PatternLessonExampleRomanji::where('pattern_lesson_example_id', $eid)
            ->whereNotIn('id', $f_array)->delete();

        foreach ($data['example_japans'] as $key => $value) {
            if ($value['id'] != null) {
                $exJapan = PatternLessonExampleJapan::find($value["id"]);
                $exJapan->text_kanji = $value['text_kanji'];
                $exJapan->text_idn = $value['text_idn'];
                $exJapan->text_hiragana = $value['text_hiragana'];
                $exJapan->is_highlighted = @$value['is_highlighted'] ? 1 : 0;
                $exJapan->update();
            } else {
                $exJapan = new PatternLessonExampleJapan();
                $exJapan->code = Str::random(15);
                $exJapan->text_kanji = $value['text_kanji'];
                $exJapan->text_idn = $value['text_idn'];
                $exJapan->text_hiragana = $value['text_hiragana'];
                $exJapan->is_highlighted = @$value['is_highlighted'] ? 1 : 0;
                $exJapan->pattern_lesson_example_id = $eid;
                $exJapan->save();
            }
        }

        foreach ($data['example_romanjis'] as $value) {
            if ($value['id'] != null) {
                $exRmj = PatternLessonExampleRomanji::find($value['id']);
                $exRmj->text = $value['text'];
                $exRmj->is_highlighted = @$value['is_highlighted'] ? 1 : 0;
                $exRmj->update();
            } else {
                $exRmj = new PatternLessonExampleRomanji();
                $exRmj->code = Str::random(15);
                $exRmj->pattern_lesson_example_id = $eid;
                $exRmj->text = $value['text'];
                $exRmj->is_highlighted = @$value['is_highlighted'] ? 1 : 0;
                $exRmj->save();
            }
        }


        return $lesson;
    }
}
