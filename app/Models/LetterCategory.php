<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterCategory extends Model
{

    protected $table = 'letter_categories';
    protected $guarded = ['id'];

     public function category() {
        return $this->belongsTo(Letter::class, 'letter_category_id');
    }
}
