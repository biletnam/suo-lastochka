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
        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            'name' => 'Admin',
            'description' => 'Admin',
        ]);

        DB::table('roles')->insert([
            'name' => 'Config',
            'description' => 'Config',
        ]);

        DB::table('roles')->insert([
            'name' => 'Operator',
            'description' => 'Оператор',
        ]);

        DB::table('roles')->insert([
            'name' => 'Reception',
            'description' => 'Регистратор',
        ]);

    }
}
