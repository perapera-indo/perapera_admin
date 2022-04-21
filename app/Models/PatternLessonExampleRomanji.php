<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternLessonExampleRomanji extends Model
{

    protected $table = 'pattern_lesson_example_romanjis';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
