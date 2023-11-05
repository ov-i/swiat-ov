<?php

use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Tickets\TicketService;

test('should pick operator for ticket', function () {
    $userMock = mock(User::class);
    $ticketMock = mock(Ticket::class);
    $ticketServiceMock = mock(TicketService::class);

    $ticketServiceMock->shouldReceive('pickOperator')
        ->once()
        ->andReturn($ticketMock);

    expect($ticketServiceMock->pickOperator($ticketMock, $userMock))->not->toBeEmpty();
});
