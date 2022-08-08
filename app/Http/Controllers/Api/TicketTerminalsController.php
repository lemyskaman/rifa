<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TerminalResource;
use App\Http\Resources\TerminalCollection;

class TicketTerminalsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $search = $request->get('search', '');

        $terminals = $ticket
            ->terminals()
            ->search($search)
            ->latest()
            ->paginate();

        return new TerminalCollection($terminals);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Ticket $ticket)
    {
        $this->authorize('create', Terminal::class);

        $validated = $request->validate([
            'number' => ['required', 'numeric'],
            'status' => ['required', 'in:available,saved,unavailable'],
        ]);

        $terminal = $ticket->terminals()->create($validated);

        return new TerminalResource($terminal);
    }
}
