<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterVerbGroup extends Model
{

    protected $table = 'master_verb_groups';
    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
