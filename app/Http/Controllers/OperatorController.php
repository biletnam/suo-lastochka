<?php

namespace suo\Http\Controllers;

use Illuminate\Http\Request;

use suo\Http\Requests;

use suo\Repositories\TicketRepository;

class OperatorController extends Controller
{
    /**
     * Получение/изменение заявок
     *
     * @var TicketRepository
     */
    protected $tickets;

    /**
     * Создание контроллера
     *
     * @param TicketRepository $tickets
     */
    public function __construct(TicketRepository $tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Display a list of terminals.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('operators.index', [
            'tickets' => $this->tickets->forOperator(),
        ]);
    }

    public function call(Request $request)
    {
        $this->tickets->call($request->ticket);

        return redirect('/operator');
    }

    public function close(Request $request)
    {
        $this->tickets->close($request->ticket);

        return redirect('/operator');
    }

}
