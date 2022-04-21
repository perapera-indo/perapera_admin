<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbMiniCourseQuestion extends Model
{

    protected $table = 'verb_mini_course_questions';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
