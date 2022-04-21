<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticleEducationChapter extends Model
{

    protected $table = 'particle_education_chapters';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
