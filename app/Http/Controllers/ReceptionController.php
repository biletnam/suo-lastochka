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

        $weeks = Timetemplate::getDaysTo2Weeks();

//        $tickets = $room_repo->countTicketsByRoomsAndDays($rooms->pluck('id'),
//                $weeks['current'][0]['long'],
//                $weeks['next'][count($weeks['next']) - 1]['long']);
//
//        $ticketByDays = ['current' => [], 'next' => []];
//        foreach ($weeks['current'] as $index => $data) {
//            $current = $data['short'];
//            $ticketByDays['current'][$current] = (!isset($dates[$current])) ? 0 : $dates[$current];
//            $next = $weeks['next'][$index]['short'];
//            $countByDate['next'][$index] = (!isset($dates[$next])) ? 0 : $dates[$next];
//        }


        return view('reception.index', [
            'rooms' => $rooms,
            'weeks' => $weeks,
//            'tickets' => $tickets
        ]);
    }
}
