<?php

use App\Data\Ticket\CreateTicketRequestData;
use App\Enums\Auth\RoleNamesEnum;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Repositories\Eloquent\Tickets\TicketRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class)->in('Feature');

test('user tickets can be create', function () {
    $ticketRepositoryMock = mock(TicketRepository::class);
    $ticketModel = mock(Ticket::class);

    $ticketRepositoryMock->shouldReceive('createTicket')
        ->once()
        ->andReturn($ticketModel);

    $this->actingAs($user = User::factory()->create());
    // $user->assignRole([RoleNamesEnum::user()->value, RoleNamesEnum::vipMember()->value]);

    $this->withSession(['auth.password_confirmed_at' => time()]);

    $ticketRequestData = CreateTicketRequestData::from([
        'title' => Str::random(10)
    ]);

    $ticket = $ticketRepositoryMock->createTicket($ticketRequestData);

    assert($ticket instanceof Ticket);
    // assert(count($user->tickets()->get()) > 0);
    expect($user->tickets()->where('title', $ticket->title)->exists())->toBeTrue();
    expect($user->tickets()->first()->title)->toBe($ticket->title);

    $ticketModel->fresh();
    $user->fresh();
});
