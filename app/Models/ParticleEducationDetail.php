<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticleEducationDetail extends Model
{

    protected $table = 'particle_education_details';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
