<?php

declare(strict_types=1);

namespace App\Services\Tickets;

use App\Exceptions\InvalidOperatorAssignmentException;
use App\Models\Tickets\Ticket;
use App\Models\User;

class TicketService
{
    /**
     * Picks an operator for current ticket
     *
     * @param User& $operator A user with role moderator / admin.
     * @param Ticket& $ticket Already existing ticket
     *
     * @return bool
     * @throws InvalidOperatorAssignmentException If user is a ticket
     */
    public function pickOperator(User &$operator, Ticket &$ticket): bool
    {
        if ($ticket->user_id === $operator->id) {
            throw new InvalidOperatorAssignmentException(__('ticket.invalid_operator'));
        }

        return $ticket->update([
            'assigned_to' => $operator->id,
        ]);
    }
}
