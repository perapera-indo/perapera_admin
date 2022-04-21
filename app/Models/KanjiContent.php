<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanjiContent extends Model
{

    protected $table = 'kanji_contents';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
