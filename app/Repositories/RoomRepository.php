<?php

namespace suo\Repositories;

use suo\Room;
use suo\Terminal;

/**
 * Description of TicketRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class RoomRepository
{
    public function forTerminal($terminal_id)
    {
        $terminal = Terminal::find($terminal_id);

        return $terminal->rooms;
    }

}
