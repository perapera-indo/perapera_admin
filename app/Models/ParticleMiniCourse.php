<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticleMiniCourse extends Model
{

    protected $table = 'particle_mini_courses';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
