<?php

namespace App\Actions\Tickets;

use App\Actions\Action;
use App\Data\Ticket\CreateTicketRequestData;
use App\Models\Tickets\Ticket;
use App\Repositories\Eloquent\Tickets\TicketRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class CreateTicket extends Action
{
    public function __construct(
        private readonly TicketRepository $ticketRepository
    ) {
    }

    /**
     * @param CreateTicketRequestData $requestData
     * @return Ticket|null
     */
    public function execute(Data $requestData): ?Model
    {
        return $this->ticketRepository->createTicket($requestData);
    }
}
