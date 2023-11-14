<?php

declare(strict_types=1);

namespace App\Services\Tickets;

use App\Models\Tickets\Ticket;
use App\Models\User;

class TicketService
{
    /**
     * Picks an operator for current ticket
     *
     * @param Ticket $ticket Already existing ticket
     * @param User $operator A user with role moderator / admin.
     *
     * @return Ticket
     */
    public function pickOperator(Ticket $ticket, User $operator): Ticket
    {
        $ticket->update([
            'assigned_to' => $operator->id,
        ]);

        return $ticket;
    }
}
