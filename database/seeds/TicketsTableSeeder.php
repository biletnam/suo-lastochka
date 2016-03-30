<?php

use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tickets')->truncate();

        factory(suo\Ticket::class, 10)->create();
        factory(suo\Ticket::class, 'ticket_closed', 5)->create();
        factory(suo\Ticket::class, 'ticket_accepted')->create();

        factory(suo\Ticket::class, 15)->create(['room_id' => 2]);
        factory(suo\Ticket::class, 'ticket_closed', 5)->create(['room_id' => 2]);
        factory(suo\Ticket::class, 'ticket_accepted')->create(['room_id' => 2]);

        factory(suo\Ticket::class, 5)->create(['room_id' => 3]);
        factory(suo\Ticket::class, 'ticket_closed', 5)->create(['room_id' => 3]);
    }
}
