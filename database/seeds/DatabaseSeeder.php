<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        $this->call(RoomsTableSeeder::class);
        $this->call(PanelsTableSeeder::class);
        $this->call(TerminalsTableSeeder::class);

        $this->call(ChecksTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
    }
}
