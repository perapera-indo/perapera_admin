<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocabularyMiniCourse extends Model
{

    protected $table = 'vocabulary_mini_courses';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
