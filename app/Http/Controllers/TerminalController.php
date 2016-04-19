<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use suo\Http\Requests;

use suo\Terminal;
use suo\Room;
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

        $monday = strtotime('Monday this week');
        $week0 = [];
        $week1 = [];
        for ($i = 0; $i < 5; $i++) {
            $week0[] = date('d.m', strtotime("+$i day", $monday));
            $week1[] = date('d.m', strtotime("+" . ($i + 7) . " day", $monday));
        }

        return view('terminals.show', [
            'terminal' => $terminal,
            'week0' => $week0,
            'week1' => $week1,
            'weeks' => json_encode([$week0, $week1])
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

        $admission_time = $request->date;
        if ('today' == $admission_time) {
            $admission_time = date('Y-m-d H:i:s');
        } else {
            $date = explode('.', $admission_time);
            $admission_time = date('Y-m-d H:i:s', strtotime('2016-' . $date[1] . '-' . $date[0]));
        }

        $check_data = $ticketRepo->createTicket($request->room, $admission_time);

        return response()->json($check_data);
    }

    public function ticketcount(Request $request)
    {
        $room_repo = new RoomRepository();

        $rooms = $request->rooms;

        $result = $room_repo->countTicketsByRooms($rooms);

        return response()->json($result);
    }

    public function ticketcountbyday(Request $request)
    {
        $room_repo = new RoomRepository();

        $date1 = date('Y-m-d', strtotime($request->date1 . '.' . date('Y')));
        $date2 = date('Y-m-d', strtotime($request->date2 . '.' . date('Y')));

        $room = $request->room;

        $counts = $room_repo->countTicketsByRoomAndDate($room, $date1, $date2);

        $monday = strtotime('Monday this week');
        $dates = [];
        foreach ($counts as $data) {
            $dates[date('d.m', strtotime($data->admission_date))] = $data->ticket_count;
        }
        for ($i = 0; $i < 5; $i++) {
            $date0 = date('d.m', strtotime("+$i day", $monday));
            $count0 = 0;
            if (isset($dates[$date0])) {
                $count0 = $dates[$date0];
            }
            $week0[] = $count0;

            $date1 = date('d.m', strtotime("+" . ($i + 7) . " day", $monday));
            $count1 = 0;
            if (isset($dates[$date1])) {
                $count1 = $dates[$date1];
            }
            $week1[] = $count1;
        }

        return response()->json(['weeks' => [$week0, $week1]]);
    }
}
