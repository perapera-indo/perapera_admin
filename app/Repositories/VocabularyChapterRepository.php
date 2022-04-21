<?php

namespace App\Repositories;

use App\Models\VocabularyChapter;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VocabularyChapterRepository
{
    public function create($data)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 20 detik
            'timeout'  => 20,
        ]);

        $chapter = new VocabularyChapter();

        if (isset($data['img'])) { // for image color
            $image = base64_encode(file_get_contents($data['img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'vocabulary_chapter',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);

            $chapter->img = $img_url->data->path;
        }

        $chapter->code = Str::random(15);
        $chapter->name = $data['name'];
        $chapter->master_group_id = $data['master_group_id'];
        $chapter->is_active = $data["is_active"];
        $chapter->save();

        return $chapter;
    }

    public function update($data, $id)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 20,
        ]);

        $chapter = VocabularyChapter::find($id);

        if (isset($data['img'])) {
            $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $chapter->img);

            // for image
            $image = base64_encode(file_get_contents($data['img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'vocabulary_chapter',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $chapter->img = $img_url->data->path;
        }

        $chapter->name = $data['name'];
        $chapter->master_group_id = $data['master_group_id'];
        $chapter->is_active = $data['is_active'];
        $chapter->update();

        return $chapter;
    }
}
