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
     * Display a list of terminals.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $terminals = Terminal::all();

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
        $perPage = 9;
        $terminal = $request->terminal;

        $room_repo = new RoomRepository();

        $rooms = $room_repo->forTerminal($terminal, $perPage);

        if (0 == count($rooms)) {
            return redirect("/terminals");
        }

        if ($request->ajax()) {
            if (false != $rooms->hasMorePages()) {
                $rooms->suoNextPage = $rooms->currentPage() + 1;
            } else if (1 != $rooms->currentPage()) {
                $rooms->suoNextPage = 1;
            } else {
                $rooms->suoNextPage = 0;
            }

            $room_ids = $rooms->pluck('id')->all();

            return response()->json([
                    'rooms' => $room_ids,
                    'page' => view('terminals.page', [
                        'rooms' => $rooms,
                    ])->render()
            ]);
        } else {
            return view('terminals.show', [
                'terminal' => $terminal,
            ]);
        }
    }

    public function createticket(Request $request)
    {
        $ticketRepo = new TicketRepository();

        $admission_time = $request->date;
        if ('today' == $admission_time) {
            $admission_time = date('Y-m-d H:i:s');
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
