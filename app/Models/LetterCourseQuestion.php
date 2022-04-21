<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterCourseQuestion extends Model
{

    protected $table = 'letter_course_questions';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
