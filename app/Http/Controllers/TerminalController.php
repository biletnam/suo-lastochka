<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

use suo\Http\Requests;

use suo\Terminal;
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
            'weeks' => json_encode([$week0, $week1]),
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

        return response()->json([
                'rooms' => $rooms->pluck('id')->all(),
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

        $date = $request->date;
        if ('today' == $date) {
            $date = date('Y-m-d');
        }

        $counts = $room_repo->countTicketsByRoomsAndDate($request->rooms, $date);

        return response()->json($counts);
    }
}
