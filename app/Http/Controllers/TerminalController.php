<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Terminal;
use suo\Room;
use suo\Repositories\TicketRepository;

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
        return redirect("/terminal/{$request->terminal}/page/0");
    }

    /**
     * Display a list of terminals.
     *
     * @param  Request  $request
     * @return Response
     */
    public function page(Request $request)
    {
        $rooms = Room::all();

        return view('terminals.page', [
            'rooms' => $rooms,
        ]);
    }

    public function createticket(Request $request)
    {
        $ticketRepo = new TicketRepository();

        $ticketRepo->createTicket($request->room);

        return redirect('/terminals');
    }
}
