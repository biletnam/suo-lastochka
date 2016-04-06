<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

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
        return redirect("/terminal/page/{$request->terminal}/page/1");
    }

    /**
     * Display a list of terminals.
     *
     * @param  Request  $request
     * @return Response
     */
    public function page(Request $request)
    {
        $perPage = 9;

        $room_repo = new RoomRepository();

        $rooms = $room_repo->forTerminal($request->terminal, $perPage);

        if (0 == count($rooms)) {
            return redirect("/terminals");
        }

        if (false != $rooms->hasMorePages()) {
            $rooms->suoNextPage = $rooms->currentPage() + 1;
        } else if (1 != $rooms->currentPage()) {
            $rooms->suoNextPage = 1;
        } else {
            $rooms->suoNextPage = 0;
        }

        return view('terminals.page', [
            'rooms' => $rooms,
        ]);
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
}
