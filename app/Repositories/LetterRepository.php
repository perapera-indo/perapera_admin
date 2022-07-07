<?php

namespace App\Repositories;

use App\Models\Letter;
use Illuminate\Support\Str;

class LetterRepository
{
    public function createNew($data)
    {
        $letter = new Letter;

        $url = $data['category']=="2" ? "uploads/katakana/" : "uploads/hiragana/";

        if (!empty($data['color_image_url'])) {
            $uploadImage = upload_file($data['color_image_url'], $url, 'image');
            $letter->color_image_url = $uploadImage['original'];
        }

        if (!empty($data['image_url'])) {
            $uploadImage = upload_file($data['image_url'], $url, 'image');
            $letter->image_url = $uploadImage['original'];
        }


        $letter->code = Str::random(10);
        $letter->letter = $data['letter'];
        $letter->romanji = $data['romanji'];
        $letter->total_stroke = $data['total_stroke'];
        $letter->letter_category_id = $data['category'];
        $letter->is_active = 1;
        $letter->desc = $data["desc"];
        $letter->save();

        return $letter;
    }

    public function updateLetter($data, $id)
    {

        $letter = Letter::find($id);

        $url = $data['category']=="2" ? "uploads/katakana/" : "uploads/hiragana/";

        if (!empty($data['color_image_url'])) {
            $uploadImage = upload_file($data['color_image_url'], $url, 'image');
            $letter->color_image_url = $uploadImage['original'];
        }

        if (!empty($data['image_url'])) {
            $uploadImage = upload_file($data['image_url'], $url, 'image');
            $letter->image_url = $uploadImage['original'];
        }

        $letter->letter = $data['letter'];
        $letter->romanji = $data['romanji'];
        $letter->total_stroke = $data['total_stroke'];
        $letter->letter_category_id = $data['category'];
        $letter->is_active = $data['is_active'];
        $letter->desc = $data["desc"];
        $letter->update();

        return $letter;
    }
}
