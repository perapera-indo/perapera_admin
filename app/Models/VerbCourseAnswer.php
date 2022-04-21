<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbCourseAnswer extends Model
{

    protected $table = 'verb_course_answers';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
