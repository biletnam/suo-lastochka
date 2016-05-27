<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use Auth;

use suo\Repositories\TicketRepository;
use suo\Repositories\RoomRepository;
use suo\Room;

class OperatorController extends Controller
{
    /**
     * Получение/изменение заявок
     *
     * @var TicketRepository
     */
    protected $tickets;

    /**
     *
     * @var int
     */
    protected $operator;

    /**
     * Создание контроллера
     *
     * @param TicketRepository $tickets
     */
    public function __construct(TicketRepository $tickets)
    {
        $this->tickets = $tickets;

        $this->operator = Auth::user()->id;
    }

    public function index(Request $request)
    {
        $room_id = $request->query('room', 'no');
        if ('no' == $room_id) {
            return redirect()->action('OperatorController@rooms');
        }

        return redirect()->action('OperatorController@tickets', ['room' => $room_id,
            'window' => $request->query('window', 1)]);
    }

    public function tickets(Request $request)
    {
        $room_id = $request->query('room', 'no');
        if ('no' == $room_id) {
            return redirect()->action('OperatorController@rooms');
        }

        $window = $request->query('window');

        $room = Room::find($room_id);
        $desc = $room->description;
        if ($room->window_count > 1) {
            $desc .= ' - окно ' . $window;
        }

        $request->session()->put('room', $room_id);
        $request->session()->put('window', $window);

        return view('operators.tickets', [
            'tickets' => $this->tickets->forOperator($room_id, $window),
            'title_room' => $desc
        ]);
    }

    public function checks(Request $request)
    {
        $room = $request->session()->get('room');
        $window = $request->session()->get('window');

        $data = $this->tickets->forOperator($room, $window);

        return response()->json($data);
    }

    public function call(Request $request)
    {
        $this->tickets->call($request->ticket, $request->session()->get('window'));

        return $this->checks($request);
    }

    public function accept(Request $request)
    {
        $this->tickets->accept($request->ticket, $request->session()->get('window'));

        return $this->checks($request);
    }

    public function close(Request $request)
    {
        $this->tickets->close($request->ticket, $request->session()->get('window'));

        return $this->checks($request);
    }

    public function rooms(Request $request)
    {
        $room_repo = new RoomRepository();
        $rooms = $room_repo->forOperator($this->operator);

        return view('operators.rooms', [
            'rooms' => $rooms,
            'title_room' => 'Выбор кабинета'
        ]);
    }

    public function selectroom(Request $request)
    {
        $room = $request->room;
        $window = 1;
        if (false !== strpos($room, '-')) {
            $parts = explode('-', $room);
            $room = $parts[0];
            $window = $parts[1];
        }

        return redirect()->action('OperatorController@tickets', ['room' => $room, 'window' => $window]);
    }

}
