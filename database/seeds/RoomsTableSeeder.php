<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->truncate();

        DB::table('rooms')->insert([
            'name' => 'reg',
            'description' => 'Регистратура',
        ]);

        DB::table('rooms')->insert([
            'name' => 'ter',
            'description' => 'Терапия',
            'ip' => '192.168.203.2',
            'max_day_record' => 5,
            'can_record' => 1,
        ]);

        DB::table('rooms')->insert([
            'name' => 'urolog',
            'description' => 'Уролог',
            'ip' => '192.168.203.1',
            'max_day_record' => 10,
            'can_record' => 1,
            'can_record_by_time' => 1,
        ]);

        factory(suo\Room::class, 50)->create();
    }
}
