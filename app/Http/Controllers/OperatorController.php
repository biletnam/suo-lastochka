<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Ticket;

class OperatorController extends Controller
{
    /**
     * Display a list of terminals.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tickets = Ticket::with(['room' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->get();

        return view('operators.index', [
            'tickets' => $tickets,
        ]);
    }

    public function call(Request $request)
    {
//        $ticketRepo = new TicketRepository();
//
//        $ticketRepo->createTicket($request->room);
//
        return redirect('/operator');
    }

}
