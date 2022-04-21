<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterVerbWord extends Model
{

    protected $table = 'master_verb_words';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
