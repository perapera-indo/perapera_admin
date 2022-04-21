<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterCourse extends Model
{

    protected $table = 'letter_courses';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
