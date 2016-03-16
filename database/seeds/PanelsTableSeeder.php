<?php

use Illuminate\Database\Seeder;

class PanelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('panels')->truncate();
        DB::table('panel_room')->truncate();

        factory(suo\Panel::class, 10)->create();

        suo\Panel::find(1)->rooms()->attach([1,2,3,4]);
        suo\Panel::find(2)->rooms()->attach([1,2,3,4,5,6]);
        suo\Panel::find(3)->rooms()->attach([10,11,12]);
        suo\Panel::find(4)->rooms()->attach([20]);
    }
}
