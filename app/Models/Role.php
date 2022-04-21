<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = ['id'];

    public function UserRoles() {
        return $this->belongsToMany('App\Models\User','role_users','role_id');
    }

    public function getRoles()
    {
        return static::select('id', 'name', 'slug')
            ->get();
    }
    public function getRolesSuperAdmin()
    {
        return static::select('id','name','slug')
            ->where('slug','=','superadmin')
            ->get();
    }

    public function scopeExceptSuperAdmin($query)
    {
        return $query->where('slug', '!=', 'super-admin');
    }
}
