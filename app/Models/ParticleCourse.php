<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticleCourse extends Model
{

    protected $table = 'particle_courses';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
