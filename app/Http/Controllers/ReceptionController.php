<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Repositories\RoomRepository;
use suo\Timetemplate;

class ReceptionController extends Controller
{
    public function index()
    {
        $room_repo = new RoomRepository();
        $rooms = $room_repo->forReception();
        $room_ids = $rooms->pluck('id');

        $weeks = Timetemplate::getDaysTo2Weeks();

        $tickets = $room_repo->countTicketsByRoomsAndDays($room_ids,
                $weeks['current'][0]['long'],
                $weeks['next'][count($weeks['next']) - 1]['long']);

        /**
         * Нужен массив
         * [ 1 (room_id) => [ day1 => count, day2 => count ]
         *   2 (room_id_ => ...
         */

        $ticketByRoomsAndDays = [];
        $roomData = [];
        foreach ($rooms as $room) {
            $ticketByRoomsAndDays[$room->id] = [];

            $roomData[$room->id]['max_day_record'] = $room->max_day_record;
            $roomData[$room->id]['can_record'] = $room->can_record;
            $roomData[$room->id]['can_record_by_time'] = $room->can_record_by_time;
            $roomData[$room->id]['description'] = $room->description;
        }
        foreach ($tickets as $data) {
            $ticketByRoomsAndDays[$data->room][$data->a_date] = $data->ticket_count;
        }

        return view('reception.index', [
            'rooms' => $rooms,
            'roomData' => json_encode($roomData),
            'weeks' => $weeks,
            'tickets' => $ticketByRoomsAndDays
        ]);
    }
}
