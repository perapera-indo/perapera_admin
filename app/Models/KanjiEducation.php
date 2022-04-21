<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanjiEducation extends Model
{

    protected $table = 'kanji_educations';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
