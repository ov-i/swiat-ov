<?php

use App\Data\Ticket\CreateTicketRequestData;
use App\Models\Tickets\Ticket;
use App\Repositories\Eloquent\Tickets\TicketRepository;
use Illuminate\Support\Str;

describe('Tickets system', function () {
    beforeEach(function () {
        $ticketModel = mock(Ticket::class);

        $ticketModel->shouldReceive('getAttribute')
            ->once()
            ->andReturn('string');

        $ticketModel->shouldReceive('query')
            ->once()
            ->andReturnSelf();

        $ticketModel->shouldReceive('create')
            ->once()
            ->andReturnSelf();

        $this->ticketRepository = new TicketRepository($ticketModel);
    });

    it('user tickets can be create', function () {
        $ticketRequestData = CreateTicketRequestData::from([
            'title' => Str::random(10)
        ]);

        $ticket = $this->ticketRepository->createTicket($ticketRequestData);

        assert($ticket instanceof Ticket);
        expect($ticket->title)->not()->toBeNull();
    });

    afterEach(function () {
        $this->ticketRepository = null;
    });
});
