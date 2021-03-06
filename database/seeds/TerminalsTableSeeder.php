<?php

use Illuminate\Database\Seeder;

class TerminalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terminals')->truncate();
        DB::table('room_terminal')->truncate();

        factory(suo\Terminal::class, 10)->create();

        suo\Terminal::find(1)->rooms()->attach([1,2,3]);
        suo\Terminal::find(2)->rooms()->attach([1,2,3,4,5,6]);
        suo\Terminal::find(3)->rooms()->attach(range(1,17));
        suo\Terminal::find(4)->rooms()->attach([20]);
   }
}
