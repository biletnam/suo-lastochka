<?php

use Illuminate\Database\Seeder;

class ChecksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('checks')->truncate();

        factory(suo\Check::class, 10)->create();
    }
}
