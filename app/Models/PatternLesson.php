<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternLesson extends Model
{

    protected $table = 'pattern_lessons';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
