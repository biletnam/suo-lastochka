<?php

namespace suo\Repositories;

use DB;

use suo\Panel;
use suo\Ticket;
use suo\Room;

/**
 * Description of TicketRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class TicketRepository
{
    public function forPanel(Panel $panel)
    {
        return Ticket::with(['room' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->get();
    }

    public function forRooms($rooms)
    {
        $tickets = DB::table('tickets')
            ->join('checks', 'checks.id', '=', 'tickets.check_id')
            ->whereBetween('tickets.admission_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereIn('tickets.room_id', $rooms)
            ->whereIn('tickets.status', [Ticket::NEWTICKET, Ticket::CALLED, Ticket::ACCEPTED])
            ->orderBy('tickets.room_id')
            ->orderBy('tickets.window')
            ->orderBy('tickets.admission_date')
            ->get(['tickets.room_id'
                , 'tickets.window'
                , 'tickets.admission_date'
                , 'tickets.status'
                , 'checks.number AS check_number'
                ]
            );

        $result = $this->convertPanelData($tickets);

        return $result;
    }

    public function forOperator($room, $window)
    {
        $tickets = DB::table('tickets')
            ->leftJoin('checks', 'checks.id', '=', 'tickets.check_id')
            ->whereBetween('tickets.admission_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->where('tickets.room_id', $room)
            ->whereIn('tickets.status', [Ticket::NEWTICKET, Ticket::CALLED, Ticket::ACCEPTED])
            ->orderBy('tickets.admission_date')
            ->get([
                'tickets.id'
                , 'tickets.room_id'
                , 'tickets.window'
                , 'tickets.admission_date'
                , 'tickets.status'
                , 'checks.number AS check_number'
            ]);

        $result = $this->convertOperatorData($tickets, $window);

        return $result;
    }

    public function createTicket($room_id, $admission_time, $with_time, $created_by_type, $created_by_id)
    {
        $result = ['error' => ''];

        $room = Room::find($room_id);

        if (!$room) {
            $result['error'] = 'No room';
        } else {
            $date = $admission_time;

            $check_repo = new CheckRepository();
            $check = $check_repo->newCheckToDate($date);

            $ticket = new Ticket([
                'room_id' => $room->id,
                'check_id' => $check->id,
                'admission_date' => $admission_time,
                'status' => Ticket::NEWTICKET,
                'created_by_type' => $created_by_type,
                'created_by_id' => $created_by_id
            ]);

            if (true != $ticket->save()) {
                $result['error'] = 'Not saved';
            } else {
                $result['number'] = $check->number;
                $result['operator'] = '';
                $result['room-number'] = '';
                $result['room-description'] = $room->description;
                $start = date('d.m.Y', strtotime($admission_time));
                if ($with_time) {
                    $start = date('d.m.Y H:i', strtotime($admission_time));
                }
                $result['start-date'] = $start;
                $result['get-time'] = date('d.m.Y H:i:s');
            }
        }

        return $result;
    }

    public function call($ticket_id, $window)
    {
        return $this->setStatus($ticket_id, Ticket::CALLED, $window);
    }

    public function accept($ticket_id, $window)
    {
        return $this->setStatus($ticket_id, Ticket::ACCEPTED, $window);
    }

    public function close($ticket_id, $window)
    {
        return $this->setStatus($ticket_id, Ticket::CLOSED, $window);
    }

    private function setStatus($ticket_id, $status, $window)
    {
        $ticket = Ticket::find($ticket_id);

        if (null != $ticket) {
            $ticket->status = $status;
            $ticket->window = $window;

            $ticket->save();
        }

        return $ticket;
    }

    private function convertPanelData($tickets)
    {
        $result = [];

        $result['count'] = count($tickets);
        $init_room = [
            'accepted' => '',
            'called' => '',
            'next' => '',
        ];
        if (count($tickets) > 0) {
            $current_room_id = current($tickets)->room_id;
            $window = 1;
            $result['rooms'][$current_room_id][$window] = $init_room;

            foreach ($tickets as $ticket) {
                if (
                        $ticket->room_id != $current_room_id
                        || $ticket->window != $window) {
                    $current_room_id = $ticket->room_id;
                    $window = $ticket->window;
                    $result['rooms'][$current_room_id][$window] = $init_room;
                }
                if (Ticket::ACCEPTED == $ticket->status) {
                    $result['rooms'][$current_room_id][$window]['accepted'] = $ticket->check_number;
                } else if (Ticket::CALLED == $ticket->status) {
                    $result['rooms'][$current_room_id][$window]['called'] = $ticket->check_number;
                } else if ('' == $result['rooms'][$current_room_id][$window]['next']) {
                    $result['rooms'][$current_room_id][$window]['next'] = $ticket->check_number;
                }
            }
        }

        return $result;
    }

    private function convertOperatorData($tickets, $window)
    {
        $result = [];

        $result['count'] = count($tickets);
        if (count($tickets) > 0) {
            $result['accepted'] = 0;
            $result['called'] = 0;
            $result['inqueue'] = current($tickets);

            foreach ($tickets as $ticket) {
                if ($ticket->window == $window) { // вызванные и принятые считаем только на нашего окна
                    if (Ticket::ACCEPTED == $ticket->status) {
                        $result['accepted'] = $ticket;
                    } else if (Ticket::CALLED == $ticket->status) {
                        $result['called'] = $ticket;
                    }
                }
            }
        }

        return $result;
    }
}
