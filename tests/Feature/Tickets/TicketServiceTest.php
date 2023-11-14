<?php

use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Tickets\TicketService;

beforeEach(function () {
    $this->ticketService = mock(TicketService::class);
    $this->user = User::factory()->create();
    $this->ticket = mock(Ticket::class);

    $this->ticket->shouldReceive('getAttribute')
        ->atLeast()
        ->once()
        ->andReturnUsing(function (string $attr) {
            return (int) $attr;
        });
});

it('should pick operator for ticket', function () {
    $this->ticketService->shouldReceive('pickOperator')
        ->once()
        ->andReturn($this->ticket);

    $pickedOperator = $this->ticketService->pickOperator($this->ticket, $this->user);

    expect($pickedOperator)->not()->toBeEmpty();
    expect($pickedOperator->assigned_to)->not()->toBeNull();
    expect($pickedOperator->assigned_to)->toBeInt();
});
