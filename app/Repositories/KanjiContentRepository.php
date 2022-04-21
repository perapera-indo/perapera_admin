<?php

namespace App\Repositories;

use App\Models\KanjiContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class KanjiContentRepository
{
    public function create($data)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        // for image
        $image = base64_encode(file_get_contents($data['image']));
        $response_img = $client->request('POST', '/api/v1/cdn', [
            'json' => [
                'bucket' => 'kanji-content',
                'image' => $image
            ]
        ]);

        $body_img = $response_img->getBody();
        $img_url = json_decode($body_img);


        $content = new KanjiContent();
        $content->code = Str::random(15);
        $content->name = $data['name'];
        $content->kanji_chapter_id = $data['kanji_chapter_id'];
        $content->image = $img_url->data->path;
        $content->save();

        return $content;
    }

    public function update($data, $id)
    {

        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        $content = KanjiContent::find($id);

        if (isset($data['image'])) {
            $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $content->image);

            // for image
            $image = base64_encode(file_get_contents($data['image']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'kanji-content',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $content->image = $img_url->data->path;
        }


        $content->name = $data['name'];
        $content->kanji_chapter_id = $data['kanji_chapter_id'];
        $content->update();

        return $content;
    }
}
