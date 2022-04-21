<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbMiniCourse extends Model
{

    protected $table = 'verb_mini_courses';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
