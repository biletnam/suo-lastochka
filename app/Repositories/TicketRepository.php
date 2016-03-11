<?php

namespace suo\Repositories;

use suo\Panel;
use suo\Ticket;
use suo\Room;

/**
 * Description of TicketRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class TicketRepository
{
    public function forPanel(Panel $panel)
    {
        return Ticket::with(['room' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->get();
    }

    public function createTicket($room_id)
    {
        $room = Room::find($room_id);

        $ticket = new Ticket(['room_id' => $room->id]);

        $ticket->save();

        return $ticket;
    }
}
