<?php

namespace suo\Repositories;

use DB;
use suo\Panel;
use suo\Terminal;
use suo\User;
use suo\Room;

/**
 * Description of TicketRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class RoomRepository
{
    public function forTerminal($terminal_id, $perPage)
    {
        $terminal = Terminal::find($terminal_id);

        return $terminal->rooms()->simplePaginate($perPage);
    }

    public function forPanel($panel_id)
    {
        $panel = Panel::find($panel_id);

        return $panel->rooms()->get();
    }

    public function forOperator($operator_id)
    {
        $operator = User::find($operator_id);

        return $operator->rooms()->get();
    }

    public function forReception()
    {
        $rooms = Room::where('can_record', 1)->orderBy('description')->get();

        return $rooms;
    }

    /**
     * Количество заявок на сегодня по кабинетам
     * Используется в кнопках терминала для кабинетов с записью в живую очередь
     *
     * @param array $room_ids
     * @return array
     */
    public function countTicketsByRoomsForToday($room_ids)
    {
        $tickets = DB::table('tickets')
            ->select(DB::raw('count(*) as ticket_count, room_id as room'))
            ->whereBetween('admission_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->whereIn('room_id', $room_ids)
            ->groupBy('room_id')
            ->get();

        return $tickets;
    }

    /**
     * Количество заявок по дням для определённого кабинета
     * Для диалога "Запись на день"
     *
     * @param type $room_id
     * @param type $date1
     * @param type $date2
     * @return type
     */
    public function countTicketsByRoomAndDate($room_id, $date1, $date2)
    {
        $tickets = DB::table('tickets')
            ->select(DB::raw("DATE_FORMAT(admission_date, '%d.%m') as a_date, count(*) as ticket_count"))
            ->whereBetween('admission_date',
                    [date('Y-m-d 00:00:00', strtotime($date1)), date('Y-m-d 23:59:59', strtotime($date2))])
            ->where('room_id', $room_id)
            ->groupBy('a_date')
            ->get();

        return $tickets;
    }

    /**
     * Наличие заявок по времени для определённого кабинета и дня
     * Для диалога "Запись по времени"
     *
     * @param type $room_id
     * @param type $date
     * @return type
     */
    public function getTicketsByDateToTimeDialog($room_id, $date)
    {
        $date = strtotime($date);
        $times = DB::table('tickets')
            ->select(DB::raw("DATE_FORMAT(admission_date, '%H:%i') as a_time"))
            ->whereBetween('admission_date', [date('Y-m-d 00:00:00', $date), date('Y-m-d 23:59:59', $date)])
            ->where('room_id', $room_id)
            ->get();

        $collection = collect($times);
        return $collection->pluck('a_time')->flip();
    }

    /**
     * Количество заявок по кабинетам и дням
     * Для записи по телефону
     *
     * @param array $room_ids
     * @param string $date1
     * @param string $date2
     * @return array
     */
    public function countTicketsByRoomsAndDays($room_ids, $date1, $date2)
    {
        $tickets = DB::table('tickets')
            ->select(DB::raw("room_id as room, DATE(admission_date) as a_date, count(*) as ticket_count"))
            ->whereBetween('admission_date', [
                date('Y-m-d 00:00:00', strtotime($date1)),
                date('Y-m-d 23:59:59', strtotime($date2))])
            ->whereIn('room_id', $room_ids)
            ->groupBy('room_id')
            ->groupBy('a_date')
            ->get();

        return $tickets;
    }

}
