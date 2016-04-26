<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Repositories\RoomRepository;
use suo\Repositories\TicketRepository;
use suo\Timetemplate;
use suo\Room;
use suo\Ticket;
use Auth;

class ReceptionController extends Controller
{
    public function index()
    {
        $room_repo = new RoomRepository();
        $rooms = $room_repo->forReception();

        $weeks = Timetemplate::getDaysTo2Weeks();

        /**
         * Нужен массив
         * [ 1 (room_id) => [ day1 => count, day2 => count ]
         *   2 (room_id_ => ...
         */

        $ticketByRoomsAndDays = $this->getTicketByRoomsAndDays($rooms->pluck('id'), $weeks);;

        $roomData = [];
        foreach ($rooms as $room) {
            $roomData[$room->id]['max_day_record'] = $room->max_day_record;
            $roomData[$room->id]['can_record'] = $room->can_record;
            $roomData[$room->id]['can_record_by_time'] = $room->can_record_by_time;
            $roomData[$room->id]['description'] = $room->description;
        }

        return view('reception.index', [
            'rooms' => $rooms,
            'rooms_json' => json_encode($rooms->pluck('id')),
            'roomData' => json_encode($roomData),
            'weeks' => $weeks,
            'tickets' => $ticketByRoomsAndDays,
            'tickets_json' => json_encode($ticketByRoomsAndDays),
        ]);
    }

    public function createticket(Request $request)
    {
        $ticketRepo = new TicketRepository();

        $with_time = false;

        if ('today' == $request->date) {
            $admission_time = date('Y-m-d H:i:s');
        } else {
            $admission_time = $request->date;
            if ('now' == $request->time) {
                $admission_time .= date(' H:i:s');
            } else {
                $admission_time .= ' ' . $request->time;
                $with_time = true;
            }
        }

        $check_data = $ticketRepo->createTicket($request->room, $admission_time, $with_time,
                Ticket::CREATED_BY_RECEPTION, Auth::user()->id);

        return response()->json($check_data);
    }

    public function ticketcount(Request $request)
    {
        $rooms = $request->rooms;
        $weeks = Timetemplate::getDaysTo2Weeks();

        $ticketByRoomsAndDays = $this->getTicketByRoomsAndDays($rooms, $weeks);

        return response()->json($ticketByRoomsAndDays);
    }

    public function timedialog(Request $request)
    {
        $room_repo = new RoomRepository();
        $room_id = $request->room;
        $date = $request->date;

        $busyTimes = $room_repo->getTicketsByDateToTimeDialog($room_id, $date);

        $room = Room::find($room_id);

        $timetemplate = $room->timetemplate;

        $times = $timetemplate->getTimeCaption($busyTimes);

        return response()->json([
            'day' => date('d.m', strtotime($request->date)),
            'dialog' => view('reception.time', [
                'type' => $timetemplate->name,
                'times' => $times,
            ])->render()
        ]);
    }

    private function getTicketByRoomsAndDays($rooms, $weeks)
    {
        $room_repo = new RoomRepository();
        $tickets = $room_repo->countTicketsByRoomsAndDays($rooms,
                $weeks['current'][0]['long'],
                $weeks['next'][count($weeks['next']) - 1]['long']);
        $ticketByRoomsAndDays = [];
        foreach ($rooms as $room) {
            $ticketByRoomsAndDays[$room] = [];
        }
        foreach ($tickets as $data) {
            $ticketByRoomsAndDays[$data->room][$data->a_date] = $data->ticket_count;
        }

        return $ticketByRoomsAndDays;
    }
}
