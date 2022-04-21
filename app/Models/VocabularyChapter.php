<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VocabularyChapter extends Model
{

    protected $table = 'vocabulary_chapters';
    protected $guarded = ['id'];

    // public function LetterCategory() {
    //     return $this->belongsToMany('App\Models\LetterCategory','letters','letter_category_id');
    // }
}
