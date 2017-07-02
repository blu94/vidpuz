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
            'surname' => 'bluycw94',
            'givenname' => 'Yap',
            'username' => 'Cheng Wei',
            'is_active' => 1,
            'email' => 'yapchengwei@gmail.com',
            'role_id' => 1,
            'first_login' => 1,
            'birthday' => '1994-06-06 00:00:00',
            'gender' => 'M',
            'password' => '$2y$10$pVzpAgVQtN2wbki27Q1reOsztWvhyIMdlL5cdpZJ4Q13fyRPDKsHK',
            'bio' => 'test bio'
          ]
        ]);
    }
}
