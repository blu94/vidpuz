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
        //
        DB::table('users')->insert([
          [
            'surname' => 'Dummy Surname',
            'givenname' => 'Dummy Given Name',
            'username' => 'dummyusername',
            'is_active' => 1,
            'email' => 'dummyadmin@gmail.com',
            'role_id' => 1,
            'first_login' => 1,
            'birthday' => '1994-01-01 00:00:00',
            'gender' => 'M',
            'password' => bcrypt('dummypassword'),
            'bio' => 'test bio'
          ]
        ]);
    }
}
