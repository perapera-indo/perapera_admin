<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternChapter extends Model
{

    protected $table = 'pattern_chapters';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
