<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerbChange extends Model
{

    protected $table = 'verb_changes';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
