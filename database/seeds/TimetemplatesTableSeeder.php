<?php

use Illuminate\Database\Seeder;

class TimetemplatesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('timetemplates')->truncate();

        DB::table('timetemplates')->insert([
            'name' => '8_17_half_hour',
            'description' => 'прием с 8 до 17 через полчаса, перерыв с 12 до 13',
        ]);

        DB::table('timetemplates')->insert([
            'name' => '8_17_third_hour',
            'description' => 'прием с 8 до 17 через 20 минут, перерыв с 12 до 13',
        ]);
    }
}
