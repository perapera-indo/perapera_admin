<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternLessonHighlight extends Model
{

    protected $table = 'pattern_lesson_highlights';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
