<?php

use App\Exceptions\InvalidOperatorAssignmentException;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Tickets\TicketService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

describe('Ticket Operator picks', function () {
    beforeEach(function () {
        $this->ticketService = new TicketService();
    });

    it('should pick operator for ticket', function (User $operator, User $user) {
        $ticket = Ticket::factory()->for($user)->create();

        /** @var Ticket $pickedOperator */
        $pickedOperator = $this->ticketService->pickOperator($operator, $ticket);

        expect($pickedOperator)->toBeTrue();
        expect($ticket->assigned_to)->not()->toBeNull();
        expect($ticket->assigned_to)->toBeInt();
        expect($ticket->assignedToUser()->exists())->toBeTrue();
    })->with('ticket_operators');

    it(
        'should deny to pick operator, if operator is an user that created a ticket',
        function (User $operator, User $user) {
            $ticket = Ticket::factory()->for($user)->create();

            $this->expectException(InvalidOperatorAssignmentException::class);

            $pickedOperator = $this->ticketService->pickOperator($user, $ticket);

            expect($pickedOperator)->toThrow(InvalidOperatorAssignmentException::class);
        }
    )->with('ticket_operators');
});
