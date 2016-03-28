<?php

namespace suo\Repositories;

use DB;

use suo\Panel;
use suo\Ticket;
use suo\Room;
use suo\User;

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

    public function forRooms($rooms)
    {
        $result = [];

        $tickets = 
                DB::table('tickets')
    ->join('checks', 'checks.id', '=', 'tickets.check_id')
    ->get(['tickets.room_id', 'checks.number AS check_number']);

//                Ticket::/*whereIn('room_id', $rooms)
//                ->*/with('check')
//                ->get();

        $room_id = 0;
        $data = [];

        foreach ($tickets as $ticket) {
            if ($ticket->room_id != $room_id) {
                if (0 != $room_id) {
                    $result[] = $data;
                }
                $room_id = $ticket->room_id;
                $data['room'] = $room_id;
                $data['checks'] = [];
            }
            $data['checks'][] = $ticket->check_number;
        }
        $result[] = $data;

        return $result;
    }

    public function forOperator()
    {
        return Ticket::with(['room' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->get();
    }

    public function createTicket($room_id)
    {
        $result = ['error' => ''];
        $room = Room::find($room_id);

        if (!$room) {
            $result['error'] = 'no room';
        } else {
            $date = date('Y-m-d');

            $check_repo = new CheckRepository();
            $check = $check_repo->newCheckToDate($date);
            $ticket = new Ticket(['room_id' => $room->id, 'check_id' => $check->id]);

            $ticket->save();

            $result['check_number'] = $check->number;
            $result['check_room_description'] = $room->description;
        }

        return $result;
    }

    public function call($ticket_id)
    {
        return $this->setStatus($ticket_id, Ticket::CALLED);
    }

    public function close($ticket_id)
    {
        return $this->setStatus($ticket_id, Ticket::CLOSED);
    }

    private function setStatus($ticket_id, $status)
    {
        $ticket = Ticket::find($ticket_id);

        $ticket->status = $status;

        $ticket->save();

        return $ticket;
    }
}
