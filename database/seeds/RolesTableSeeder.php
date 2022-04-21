<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRoute = [
            'dashboard' => true,
            'user.index' => true,
            'user.create' => true,
            'user.store' => true,
            'user.show' => true,
            'user.edit' => true,
            'user.update' => true,
            'user.destroy' => true,
        ];

        Sentinel::getRoleRepository()->createModel()->create([
            'slug' => 'super-admin',
            'name' => 'Super Administrator',
            'permissions' => $userRoute
        ]);
    }
}
