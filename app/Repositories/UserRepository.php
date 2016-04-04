<?php

namespace suo\Repositories;

use DB;

/**
 * Description of TicketRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class UserRepository
{
    public function forAuth($room_ip)
    {
        $user_id = DB::table('room_user')
            ->join('rooms', 'rooms.id', '=', 'room_user.room_id')
            ->where('rooms.ip', $room_ip)
            ->value('user_id');

        return $user_id;
    }

}
