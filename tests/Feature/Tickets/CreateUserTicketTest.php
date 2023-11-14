<?php

use App\Data\Ticket\CreateTicketRequestData;
use App\Models\Tickets\Ticket;
use App\Repositories\Eloquent\Tickets\TicketRepository;
use Illuminate\Support\Str;

describe('Tickets system', function () {
    beforeEach(function () {
        $this->ticketRepository = mock(TicketRepository::class);
        $this->ticketModel = mock(Ticket::class);

        $this->ticketModel->shouldReceive('getAttribute')
            ->atLeast()
            ->once()
            ->andReturn('mixed');
    });

    it('user tickets can be create', function () {
        $this->ticketRepository->shouldReceive('createTicket')
            ->once()
            ->andReturn($this->ticketModel);

        $this->withSession(['auth.password_confirmed_at' => time()]);

        $ticketRequestData = CreateTicketRequestData::from([
            'title' => Str::random(10)
        ]);

        $ticket = $this->ticketRepository->createTicket($ticketRequestData);

        assert($ticket instanceof Ticket);
        expect($ticket->title)->not()->toBeNull();
    });
});
