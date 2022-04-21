<?php

namespace App\Repositories;

use App\Models\MasterVerbSentence;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class MasterVerbSentenceRepository
{
    public function create($data)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        // for image
        $image = base64_encode(file_get_contents($data['sentence_img']));
        $response_img = $client->request('POST', '/api/v1/cdn', [
            'json' => [
                'bucket' => 'sentences',
                'image' => $image
            ]
        ]);

        $body_img = $response_img->getBody();
        $img_url = json_decode($body_img);


        $sentence = new MasterVerbSentence();
        $sentence->code = Str::random(15);
        $sentence->sentence_jpn = $data['sentence_jpn'];
        $sentence->sentence_jpn_highlight = $data['sentence_jpn_highlight'];
        $sentence->sentence_romanji = $data['sentence_romanji'];
        $sentence->sentence_romaji_highlight = $data['sentence_romaji_highlight'];
        $sentence->sentence_idn = $data['sentence_idn'];
        $sentence->sentence_img= $img_url->data->path;
        $sentence->verb_change_id = $data['verb_change_id'];
        $sentence->is_active = $data['is_active'];
        $sentence->save();

        return $sentence;
    }

    public function update($data, $id)
    {

        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        $sentence = MasterVerbSentence::find($id);

        if (isset($data['sentence_img'])) {
            $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $sentence->sentence_img);

            // for image
            $image = base64_encode(file_get_contents($data['sentence_img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'sentences',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $sentence->sentence_img = $img_url->data->path;
        }


        $sentence->sentence_jpn = $data['sentence_jpn'];
        $sentence->sentence_jpn_highlight = $data['sentence_jpn_highlight'];
        $sentence->sentence_romanji = $data['sentence_romanji'];
        $sentence->sentence_romaji_highlight = $data['sentence_romaji_highlight'];
        $sentence->sentence_idn = $data['sentence_idn'];
        $sentence->verb_change_id = $data['verb_change_id'];
        $sentence->is_active = $data['is_active'];
        $sentence->update();

        return $sentence;
    }
}
