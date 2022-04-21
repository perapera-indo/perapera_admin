<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterVerbSentence extends Model
{

    protected $table = 'master_verb_sentences';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
