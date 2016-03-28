<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Room;

use suo\Panel;
use suo\Repositories\RoomRepository;
use suo\Repositories\TicketRepository;

class PanelController extends Controller
{
    /**
     * Display a list of panels.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $panels = Panel::all();

        return view('panels.index', [
            'panels' => $panels,
        ]);
    }

    public function select(Request $request)
    {
        return redirect("/panel/{$request->panel}");
    }

    public function show(Request $request)
    {
        $room_repo = new RoomRepository();

        $rooms = $room_repo->forPanel($request->panel);

        session(['panel' => $request->panel]);

        session(['rooms' => $rooms->pluck('id')->all()]);

        return view('panels.show', [
                        'rooms' => $rooms,
                    ]);
    }

    public function checks(Request $request)
    {
        $ticket_repo = new TicketRepository();
        
        $rooms = session('rooms');

        $data = $ticket_repo->forRooms($rooms);

        return response()->json($data);
    }

}
