<?php

namespace App\Repositories;

use App\Models\AbilityCourseQuestionGroup;
use App\Models\AbilityCourse;
use App\Models\AbilityCourseAnswer;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AbilityCourseQuestionGroupRepository
{
    public function create($data)
    {

        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 10 detik
            'timeout'  => 10,
        ]);

        $question = new AbilityCourseQuestionGroup;

        // for image
        if (isset($data['question_img'])) {
            $image = base64_encode(file_get_contents($data['question_img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'question_group_img',
                    'image' => $image
                ]
            ]);

            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);

            $question->question_img = $img_url->data->path;
        }

        // for sound
        if (isset($data['question_sound'])) {
            $sound = base64_encode(file_get_contents($data['question_sound']));
            $response_sound = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'question_group_sound',
                    'image' => $sound
                ]
            ]);

            $body_sound = $response_sound->getBody();
            $sound_url = json_decode($body_sound);

            $question->question_sound = $sound_url->data->path;
        }

        $question->code = Str::random(15);
        $question->question_jpn = $data['question_jpn'];
        $question->ability_course_id = $data['ability_course_id'];
        $question->is_active = isset($value["is_active"]);
        $question->save();

        return $question;
    }

    public function update($data, $id)
    {

        $client = new Client([
            'base_uri' => env('CLOUD_S3_UPLOAD'),
            // default timeout 10 detik
            'timeout'  => 10,
        ]);

        $question = AbilityCourseQuestionGroup::find($id);

        if (isset($data['question_img'])) {
            if ($question->question_img != "") {
                $response_img_del = $client->request('DELETE', '/api/v1/cdn/' . $question->question_img);
            }

            // for image
            $image = base64_encode(file_get_contents($data['question_img']));
            $response_img = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'question_group_img',
                    'image' => $image
                ]
            ]);
            $body_img = $response_img->getBody();
            $img_url = json_decode($body_img);
            $question->question_img = $img_url->data->path;
        }

        // for sound
        if (isset($data['question_sound'])) {
            if ($question->question_sound != "") {
                $response_sound_del = $client->request('DELETE', '/api/v1/cdn/' . $question->question_sound);
            }

            $sound = base64_encode(file_get_contents($data['question_sound']));
            $response_sound = $client->request('POST', '/api/v1/cdn', [
                'json' => [
                    'bucket' => 'question_group_sound',
                    'image' => $sound
                ]
            ]);

            $body_sound = $response_sound->getBody();
            $sound_url = json_decode($body_sound);

            $question->question_sound = $sound_url->data->path;
        }

        $question->question_jpn = $data['question_jpn'];
        $question->ability_course_id = $data['ability_course_id'];
        $question->is_active = $data['is_active'];

        $question->update();


        return $question;
    }
}
