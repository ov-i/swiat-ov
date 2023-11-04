<?php

declare(strict_types=1);

namespace App\Services\Tickets;

use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Eloquent\Tickets\TicketRepository;

class TicketService
{
    public function __construct(
        private readonly TicketRepository $ticketRepository,
    ) {
    }

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
        $ticket->assigned_to = $operator->user_id;
        $ticket->update();

        return $ticket;
    }
}