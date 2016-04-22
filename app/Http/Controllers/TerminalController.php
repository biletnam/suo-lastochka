<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use suo\Http\Requests;

use suo\Terminal;
use suo\Room;
use suo\Timetemplate;
use suo\Repositories\TicketRepository;
use suo\Repositories\RoomRepository;

class TerminalController extends Controller
{
    /**
     * Количество кабинетов на одном экране терминала
     * Если кабинетов больше, то выводим кнопку "Другие"
     *
     * @var int
     */
    protected $roomPerPage = 9;

    /**
     * Display a list of terminals.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $terminals = Terminal::orderBy('ip_address')
                ->get();

        return view('terminals.index', [
            'terminals' => $terminals,
        ]);
    }

    public function select(Request $request)
    {
        return redirect("/terminal/{$request->terminal}");
    }

    /**
     * Display a list of rooms.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        $terminal = $request->terminal;

        $room_repo = new RoomRepository();

        $rooms = $room_repo->forTerminal($terminal, $this->roomPerPage);

        if (0 == count($rooms)) {
            return redirect("/terminals");
        }

        $weeks = Timetemplate::getDaysTo2Weeks();

        return view('terminals.show', [
            'terminal' => $terminal,
            'weeks' => $weeks,
            'weeks_json' => json_encode($weeks),
        ]);
    }

    /**
     * Display a list of rooms.
     *
     * @param  Request  $request
     * @return Response
     */
    public function page(Request $request)
    {
        $terminal = $request->terminal;

        $room_repo = new RoomRepository();

        $rooms = $room_repo->forTerminal($terminal, $this->roomPerPage);

        $nextPage = 0; // если следующая страница равна нулю, то кнопку "Другие кабинеты" не выводим
        if (false != $rooms->hasMorePages()) {
            $nextPage = $rooms->currentPage() + 1;
        } else if (1 != $rooms->currentPage()) {
            $nextPage = 1;
        }

        $rooms->suoNextPage = $nextPage;

        $ids = [];
        $roomData = [];
        foreach ($rooms as $room) {
            $ids[] = $room->id;
            $roomData[$room->id]['max_day_record'] = $room->max_day_record;
            $roomData[$room->id]['can_record'] = $room->can_record;
            $roomData[$room->id]['can_record_by_time'] = $room->can_record_by_time;
            $roomData[$room->id]['description'] = $room->description;
        }

        return response()->json([
            'rooms' => $ids,
            'roomData' => $roomData,
            'page' => view('terminals.page', [
                    'rooms' => $rooms,
                ])->render()
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

        $check_data = $ticketRepo->createTicket($request->room, $admission_time, $with_time);

        return response()->json($check_data);
    }

    public function ticketcount(Request $request)
    {
        $room_repo = new RoomRepository();

        $rooms = $request->rooms;

        $result = $room_repo->countTicketsByRoomsForToday($rooms);

        return response()->json($result);
    }

    public function ticketcountbyday(Request $request)
    {
        $room_repo = new RoomRepository();

        $room = $request->room;

        $counts = $room_repo->countTicketsByRoomAndDate($room, $request->date1, $request->date2);

        $monday = strtotime('Monday this week');
        $dates = [];
        foreach ($counts as $data) {
            $dates[$data->a_date] = $data->ticket_count;
        }

        $weeks = Timetemplate::getDaysTo2Weeks();
        $countByDate = ['current' => [], 'next' => []];
        foreach ($weeks['current'] as $index => $data) {
            $current = $data['short'];
            $countByDate['current'][$index] = (!isset($dates[$current])) ? 0 : $dates[$current];
            $next = $weeks['next'][$index]['short'];
            $countByDate['next'][$index] = (!isset($dates[$next])) ? 0 : $dates[$next];
        }

        return response()->json(['weeks' => $countByDate]);
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
            'dialog' => view('terminals.time', [
                'type' => $timetemplate->name,
                'times' => $times,
            ])->render()
        ]);
    }

}
