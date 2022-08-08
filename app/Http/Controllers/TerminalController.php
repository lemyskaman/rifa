<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Terminal;
use Illuminate\Http\Request;
use App\Http\Requests\TerminalStoreRequest;
use App\Http\Requests\TerminalUpdateRequest;

class TerminalController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Terminal::class);

        $search = $request->get('search', '');

        $terminals = Terminal::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.terminals.index', compact('terminals', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Terminal::class);

        $tickets = Ticket::pluck('id', 'id');

        return view('app.terminals.create', compact('tickets'));
    }

    /**
     * @param \App\Http\Requests\TerminalStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TerminalStoreRequest $request)
    {
        $this->authorize('create', Terminal::class);

        $validated = $request->validated();

        $terminal = Terminal::create($validated);

        return redirect()
            ->route('terminals.edit', $terminal)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Terminal $terminal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Terminal $terminal)
    {
        $this->authorize('view', $terminal);

        return view('app.terminals.show', compact('terminal'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Terminal $terminal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Terminal $terminal)
    {
        $this->authorize('update', $terminal);

        $tickets = Ticket::pluck('id', 'id');

        return view('app.terminals.edit', compact('terminal', 'tickets'));
    }

    /**
     * @param \App\Http\Requests\TerminalUpdateRequest $request
     * @param \App\Models\Terminal $terminal
     * @return \Illuminate\Http\Response
     */
    public function update(TerminalUpdateRequest $request, Terminal $terminal)
    {
        $this->authorize('update', $terminal);

        $validated = $request->validated();

        $terminal->update($validated);

        return redirect()
            ->route('terminals.edit', $terminal)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Terminal $terminal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Terminal $terminal)
    {
        $this->authorize('delete', $terminal);

        $terminal->delete();

        return redirect()
            ->route('terminals.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
