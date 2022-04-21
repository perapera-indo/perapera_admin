<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
// use Hash;
// use DB;
use Illuminate\Support\Str;
use App\Events\EmailActivation;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createNewUser($data)
    {
        if(@!$data['password']){
            $data['password'] = Str::random(6);
        }

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        $clonePassword = $data['password'];

        $user = Sentinel::register($credentials);

        if(isset($data['role'])){
            Sentinel::findRoleBySlug($data['role'])->users()->attach(Sentinel::findById($user->id));
        }
        $activation = Activation::create($user);

        $users = User::find($user->id);
        $users->email = $data['email'];
        $users->password = Hash::make($data['password']);
        $users->first_name = $data['first_name'];
        $users->last_name = $data['last_name'];
        if (!empty($data['user_image'])) {
            $uploadImage = upload_file($data['user_image'], 'uploads/users/');
            $users->user_image = $uploadImage['original'];
        }
        $users->created_by = @user_info('id');
        if ($users->save()) {
            Activation::complete($user, $activation->code);
            DB::table('activations')
                ->where('user_id', $user->id)
                ->update([
                    'completed' => 1,
                    'completed_at' => date( 'Y-m-d H:i:s')
                ]);

            event(new EmailActivation($user,$clonePassword));
            return $user;
        }

        return null;
    }

    public function updateUser($data, $id)
    {
        $user = User::find($id);
        $role = Role::where('slug','=', $data['role'])->first();
        $user->email = $data['email'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];

        if (!empty($data['user_image'])) {
            @delete_file($user->user_image);
            $uploadImage = upload_file($data['user_image'], 'uploads/users/');
            $user->user_image = $uploadImage['original'];
        }
        $user->updated_by = @user_info('id');

        $user->update();

        $userRole = RoleUser::where('user_id','=',$id)->first();
        if($userRole) {
            $userRole->role_id = $role->id;
            $userRole->save();
        } else {
            $newUserRole = new RoleUser();
            $newUserRole->role_id = $role->id;
            $newUserRole->user_id = $id;
            $newUserRole->save();
        }

        $isSuccessUpdate = true;

        return $isSuccessUpdate;
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }

    public function changePassword($data)
    {
        $user = Sentinel::findById(Sentinel::getUser()->id);

        $user->password = Hash::make($data['password']);
        $user->password = bcrypt($data['password']);
        $user->update();

        return $user;
    }
}
