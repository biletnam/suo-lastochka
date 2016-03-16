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
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => bcrypt('aaaaaa'),
        ]);

        factory(suo\User::class, 10)->create();
    }
}
