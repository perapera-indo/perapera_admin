<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbCourse extends Model
{

    protected $table = 'verb_courses';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
