<?php

namespace App\Http\Controllers;

use App\Actions\Tickets\CreateTicket;
use App\Data\Ticket\CreateTicketRequestData;
use App\Services\Tickets\TicketService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketsController extends Controller
{
    public function __construct(
        private readonly TicketService $ticketService,
    ) {
    }

    public function create(): View
    {
        return view('tickets.index');
    }

    public function store(
        CreateTicketRequestData $requestData,
        CreateTicket $action,
    ): RedirectResponse {
        $action->execute($requestData);

        return redirect()->back();
    }
}
