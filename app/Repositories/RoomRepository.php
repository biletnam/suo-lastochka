<?php

namespace suo\Repositories;

use DB;
use suo\Panel;
use suo\Terminal;
use suo\User;

/**
 * Description of TicketRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class RoomRepository
{
    public function forTerminal($terminal_id, $perPage)
    {
        $terminal = Terminal::find($terminal_id);

        return $terminal->rooms()->simplePaginate($perPage);
    }

    public function forPanel($panel_id)
    {
        $panel = Panel::find($panel_id);

        return $panel->rooms()->get();
    }

    public function forOperator($operator_id)
    {
        $operator = User::find($operator_id);

        return $operator->rooms()->get();
    }

    public function countTicketsByRooms($room_ids, $date)
    {
        $tickets = DB::table('tickets')
            ->select(DB::raw('count(*) as ticket_count, room_id as room, admission_date'))
            ->whereBetween('admission_date',
                    [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date))])
            ->whereIn('room_id', $room_ids)
            ->groupBy('room_id')
            ->groupBy('admission_date')
            ->orderBy('room_id')
            ->orderBy('admission_date')
            ->get();

        return $tickets;
    }


    public function countTicketsByRoomsAndDate($room_ids, $date1, $date2)
    {
        $tickets = DB::table('tickets')
            ->select(DB::raw('count(*) as ticket_count, room_id as room, admission_date'))
            ->whereBetween('admission_date',
                    [date('Y-m-d 00:00:00', strtotime($date1)), date('Y-m-d 23:59:59', strtotime($date2))])
            ->whereIn('room_id', $room_ids)
            ->groupBy('room_id')
            ->groupBy('admission_date')
            ->orderBy('room_id')
            ->orderBy('admission_date')
            ->get();

        return $tickets;
    }

}
