<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternLessonExampleJapan extends Model
{

    protected $table = 'pattern_lesson_example_japans';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
