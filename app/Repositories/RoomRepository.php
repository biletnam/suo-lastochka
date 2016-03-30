<?php

namespace suo\Repositories;

use suo\Panel;
use suo\Terminal;
use suo\User;

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

        return $terminal->rooms()->simplePaginate(5);
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

}
