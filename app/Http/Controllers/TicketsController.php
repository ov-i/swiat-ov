<?php

namespace App\Http\Controllers;

use App\Actions\Tickets\CreateTicket;
use App\Data\Ticket\CreateTicketRequestData;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketsController extends Controller
{
    public function __construct(
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
