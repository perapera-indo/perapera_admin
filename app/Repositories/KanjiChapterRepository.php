<?php

namespace App\Repositories;

use App\Models\KanjiChapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class KanjiChapterRepository
{
    public function create($data)
    {
        // $client = new Client([
        //     'base_uri' => env('CLOUD_S3_UPLOAD'),
        //     // default timeout 5 detik
        //     'timeout'  => 5,
        // ]);

        // // for image
        // $image = base64_encode(file_get_contents($data['image']));
        // $response_img = $client->request('POST', '/api/v1/cdn', [
        //     'json' => [
        //         'bucket' => 'kanji',
        //         'image' => $image
        //     ]
        // ]);

        // $body_img = $response_img->getBody();
        // $img_url = json_decode($body_img);


        $chapter = new KanjiChapter();
        $chapter->code = Str::random(15);
        $chapter->name = $data['name'];
        $chapter->master_group_id = $data['master_group_id'];
        // $chapter->image = $img_url->data->path;
        $chapter->save();

        return $chapter;
    }

    public function update($data, $id)
    {

        // $client = new Client([
        //     'base_uri' => env('CLOUD_S3_UPLOAD'),
        //     // default timeout 5 detik
        //     'timeout'  => 5,
        // ]);



        // if (isset($data['image'])) {
        //     $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $chapter->image);

        //     // for image
        //     $image = base64_encode(file_get_contents($data['image']));
        //     $response_img = $client->request('POST', '/api/v1/cdn', [
        //         'json' => [
        //             'bucket' => 'kanji',
        //             'image' => $image
        //         ]
        //     ]);
        //     $body_img = $response_img->getBody();
        //     $img_url = json_decode($body_img);
        //     $chapter->image = $img_url->data->path;
        // }

        $chapter = KanjiChapter::find($id);
        $chapter->name = $data['name'];
        $chapter->master_group_id = $data['master_group_id'];
        $chapter->update();

        return $chapter;
    }
}
