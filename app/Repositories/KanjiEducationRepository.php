<?php

namespace App\Repositories;

use App\Models\KanjiChapter;
use App\Models\KanjiEducation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class KanjiEducationRepository
{
    public function create($data)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        $education = new KanjiEducation;
        // for image
        $image = base64_encode(file_get_contents($data['img_writing']));
        $response_img = $client->request('POST', '/api/v1/cdn', [
            'json' => [
                'bucket' => 'kanji',
                'image' => $image
            ]
        ]);

        $body_img = $response_img->getBody();
        $img_url = json_decode($body_img);

        if (isset($data['img_illustration'])) { // for image color
            $img_illustration = base64_encode(file_get_contents($data['img_illustration']));
            $response_img_color = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'kanji',
                    'image' => $img_illustration
                ]
            ]);
            $body_img_color = $response_img_color->getBody();
            $ilust_img = json_decode($body_img_color);

            $education->img_illustration = $ilust_img->data->path;
        }



        $education->code = Str::random(15);
        $education->scratches = $data['scratches'];
        $education->kun_yomi = $data['kun_yomi'];
        $education->img_writing = $img_url->data->path;
        $education->on_yomi = $data['on_yomi'];
        $education->kanji_chapter_id = $data['kanji_chapter_id'];
        $education->is_active = 1;
        $education->save();

        return $education;
    }

    public function update($data, $id)
    {


        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        $education = KanjiEducation::find($id);

        if (isset($data['img_writing'])) {
            $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $education->img_writing);

            // for image
            $image = base64_encode(file_get_contents($data['img_writing']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'kanji',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $education->img_writing = $img_url->data->path;
        }

        if (isset($data['img_illustration'])) {
            $response_img_col = $client->request('DELETE', '/api/v1/cdn/' . $education->img_illustration);

            // for image color
            $img_illustration = base64_encode(file_get_contents($data['img_illustration']));
            $response_img_color = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'kanji',
                    'image' => $img_illustration
                ]
            ]);

            $body_img_color = $response_img_color->getBody();
            $ilust_img = json_decode($body_img_color);
            $education->img_illustration = $ilust_img->data->path;
        }


        $education->scratches = $data['scratches'];
        $education->kun_yomi = $data['kun_yomi'];
        $education->on_yomi = $data['on_yomi'];
        $education->kanji_chapter_id = $data['kanji_chapter_id'];
        $education->is_active = $data['is_active'];
        $education->update();

        return $education;
    }
}
