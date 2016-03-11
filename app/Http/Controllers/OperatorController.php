<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Repositories\TicketRepository;

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
        $ticketRepo = new TicketRepository();

        $tickets = $ticketRepo->forOperator();

        return view('operators.index', [
            'tickets' => $tickets,
        ]);
    }

    public function call(Request $request)
    {
        $ticketRepo = new TicketRepository();

        $ticketRepo->call($request->ticket);

        return redirect('/operator');
    }

}
