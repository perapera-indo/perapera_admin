<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternCourseAnswer extends Model
{

    protected $table = 'pattern_course_answers';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
