<?php

namespace App\Repositories\Eloquent\Tickets;

use App\Data\Ticket\CreateTicketRequestData;
use App\Enums\Ticket\TicketPriorityEnum;
use App\Enums\Ticket\TicketStatusEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class TicketRepository extends BaseRepository
{
    public function __construct(Ticket $ticket)
    {
        parent::__construct($ticket);
    }

    /**
     * @param CreateTicketRequestData $requestData
     * @return Ticket|null
     */
    public function createTicket(CreateTicketRequestData $requestData): ?Ticket
    {
        /** @phpstan-ignore-next-line */
        return $this->create([
            'user_id' => auth()->id(),
            'uuid' => Uuid::uuid4(),
            ...$requestData->toArray(),
        ]);
    }

    /**
     * @param TicketPriorityEnum $priority Searched priority of tickets
     *
     * @return CursorPaginator<Model>|null
     */
    public function getTicketsByPriority(TicketPriorityEnum $priority): ?CursorPaginator
    {
        $tickets = $this->getModel()::query()
            ->where('priority', $priority->value)
            ->cursorPaginate(10);

        if ($this->isPaginationCursorEmpty($tickets)) {
            return null;
        }

        return $tickets;
    }

    /**
     * @param TicketStatusEnum $status Searched status of tickets
     *
     * @return CursorPaginator<Model>|null
     */
    public function getTicketsByStatus(TicketStatusEnum $status): ?CursorPaginator
    {
        $tickets = $this->getModel()->query()
            ->where('status', $status->value)
            ->cursorPaginate(10);

        if ($this->isPaginationCursorEmpty($tickets)) {
            return null;
        }

        return $tickets;
    }

    public function setStatus(Ticket $ticket, TicketStatusEnum $status): self
    {
        $ticket->status = (string) $status->value;
        $ticket->update();

        return $this;
    }

    public function setPriority(Ticket $ticket, TicketPriorityEnum $priority): self
    {
        $ticket->priority = (string) $priority->value;
        $ticket->update();

        return $this;
    }

    public function markAsResolved(Ticket $ticket): Ticket
    {
        $ticket->is_resolved = true;
        $ticket->update();

        return $ticket;
    }
}
