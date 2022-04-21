<?php

namespace App\Repositories;

use App\Models\AbilityCourse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class AbilityCourseRepository
{
    public function create($data)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 10 detik
            'timeout'  => 10,
        ]);

        $course = new AbilityCourse();

        if (isset($data['img'])) { // for image color
            $image = base64_encode(file_get_contents($data['img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'ability',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);

            $course->img = $img_url->data->path;
        }


        $course->code = Str::random(10);
        $course->title = $data['title'];
        $course->ability_course_chapter_id = $data['ability_course_chapter_id'];
        $course->question_count = 0;
        $course->is_active = $data['is_active'];
        $course->is_done_test = @$data['is_done_test'] = 1 ? 1 : 0;
        $course->save();

        return $course;
    }

    public function update($data, $id)
    {
        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 10 detik
            'timeout'  => 10,
        ]);

        $course = AbilityCourse::find($id);
        if (isset($data['img'])) {
            if ($course->img != null) {
                $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $course->img);
            }

            // for image
            $image = base64_encode(file_get_contents($data['img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'ability',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $course->img = $img_url->data->path;
        }
        $course->title = $data['title'];
        $course->ability_course_chapter_id = $data['ability_course_chapter_id'];
        $course->is_active = $data['is_active'];
        $course->is_done_test = @$data['is_done_test'] = 1 ? 1 : 0;
        $course->update();

        return $course;
    }
}
