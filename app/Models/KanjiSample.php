<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanjiSample extends Model
{

    protected $table = 'kanji_samples';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
