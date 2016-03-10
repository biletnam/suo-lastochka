<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Room;

use suo\Ticket;

class PanelController extends Controller
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

        return view('panels.index', [
            'tickets' => $tickets,
        ]);
    }

}
