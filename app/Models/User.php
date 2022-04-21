<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $guarded = ['id'];

    public function RoleUsers() {
        return $this->belongsToMany('App\Models\Role','role_users','user_id');
    }

    public function getUserRoles($userId)
    {
        return static::leftJoin('role_users', 'role_users.user_id','=', 'users.id')
            ->leftJoin('roles','roles.id','=','role_users.role_id')
            ->where('users.id','=',$userId)
            ->select([
                'users.id as user_id',
                'roles.id as role_id',
                'users.email',
                'users.user_image',
                'users.first_name',
                'users.last_name',
                'roles.slug as role_slug',
                'roles.name as role_name'
            ])
            ->firstOrFail();
    }

    public function scopeGetUserRole($query,$id)
    {
        return $query->leftJoin('role_users', 'role_users.user_id','=', 'users.id')
            ->leftJoin('roles','roles.id','=','role_users.role_id')
            ->where('users.id','=',$id)
            ->select([
                'users.id as user_id',
                'roles.id as role_id',
                'users.email',
                'users.user_image',
                'users.first_name',
                'users.last_name',
                'roles.slug as role_slug',
                'roles.name as role_name'
            ]);
    }

    public function scopeExceptSuperAdmin($query,$id)
    {
        return $query->getUserRole($id)
            ->where('slug', '!=', 'super-admin');
    }
}
