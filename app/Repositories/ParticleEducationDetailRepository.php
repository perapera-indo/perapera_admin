<?php

namespace App\Repositories;

use App\Models\Letter;
use App\Models\ParticleEducationDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ParticleEducationDetailRepository
{
    public function createNew($data)
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
                'bucket' => 'educations',
                'image' => $image
            ]
        ]);

        $body_img = $response_img->getBody();
        $img_url = json_decode($body_img);


        $detail = new ParticleEducationDetail();
        $detail->code = Str::random(10);
        $detail->sentence_jpn = $data['sentence_jpn'];
        $detail->sentence_romanji = $data['sentence_romanji'];
        $detail->sentence_idn = $data['sentence_idn'];
        $detail->sentence_description = $data['sentence_description'];
        $detail->sentence_img = $img_url->data->path;
        $detail->particle_education_id = $data['particle_education_id'];
        $detail->formula = $data['formula'];
        $detail->is_active = $data['is_active'];
        $detail->save();

        return $detail;
    }

    public function updateDetail($data, $id)
    {

        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 5 detik
            'timeout'  => 5,
        ]);

        $detail = ParticleEducationDetail::find($id);

        if (isset($data['sentence_img'])) {
            if ($detail->sentence_img != "" || $detail->sentence_img != "") {
                $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $detail->sentence_img);
            }

            // for image
            $image = base64_encode(file_get_contents($data['sentence_img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'educations',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $detail->sentence_img = $img_url->data->path;
        }


        $detail->sentence_jpn = $data['sentence_jpn'];
        $detail->sentence_romanji = $data['sentence_romanji'];
        $detail->sentence_idn = $data['sentence_idn'];
        $detail->sentence_description = $data['sentence_description'];
        $detail->particle_education_id = $data['particle_education_id'];
        $detail->formula = $data['formula'];
        $detail->is_active = $data['is_active'];
        $detail->update();

        return $detail;
    }
}
