<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Sentinel::registerAndActivate([
            'email' => 'admin@mail.com',
            'password' => 'masuk123',
            'first_name' => 'Super',
            'last_name' => 'Admin'
        ]);

        Sentinel::findRoleBySlug('super-admin')->users()->attach(Sentinel::findById(1));

    }
}
