<?php

namespace App\Models\Tickets;

use App\Enums\Ticket\TicketPriorityEnum;
use App\Enums\Ticket\TicketStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends \Coderflex\LaravelTicket\Models\Ticket
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'priority' => TicketPriorityEnum::class,
        'status' => TicketStatusEnum::class
    ];
}
