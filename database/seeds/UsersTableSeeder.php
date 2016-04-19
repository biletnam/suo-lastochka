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
        DB::table('role_user')->truncate();
        DB::table('room_user')->truncate();
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => bcrypt('aaaaaa'),
        ]);

        DB::table('users')->insert([
            'name' => 'Op',
            'email' => 'op@aaa.aaa',
            'password' => bcrypt('o'),
        ]);

        DB::table('users')->insert([
            'name' => 'Terivanov',
            'email' => 'ter@aaa.aaa',
            'password' => bcrypt('t'),
        ]);

        DB::table('users')->insert([
            'name' => 'Urpetrov',
            'email' => 'ur@aaa.aaa',
            'password' => bcrypt('u'),
        ]);

        factory(suo\User::class, 10)->create();

        suo\User::find(2)->roles()->attach([3]);
        suo\User::find(3)->roles()->attach([3]);
        suo\User::find(4)->roles()->attach([3]);
        suo\User::find(2)->rooms()->attach([1]);
        suo\User::find(3)->rooms()->attach([2]);
        suo\User::find(4)->rooms()->attach([3]);
    }
}
