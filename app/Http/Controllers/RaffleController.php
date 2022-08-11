<?php

namespace App\Http\Controllers;

use App\Models\Raffle;
use Illuminate\Http\Request;
use App\Http\Requests\RaffleStoreRequest;
use App\Http\Requests\RaffleUpdateRequest;

class RaffleController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Raffle::class);

        $search = $request->get('search', '');

        $raffles = Raffle::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.raffles.index', compact('raffles', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Raffle::class);

        return view('app.raffles.create');
    }

    /**
     * @param \App\Http\Requests\RaffleStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RaffleStoreRequest $request)
    {
        $this->authorize('create', Raffle::class);

        $validated = $request->validated();

        $raffle = Raffle::create($validated);

        return redirect()
            ->route('raffles.edit', $raffle)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Raffle $raffle
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Raffle $raffle)
    {
        $this->authorize('view', $raffle);

        return view('app.raffles.show', compact('raffle'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Raffle $raffle
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Raffle $raffle)
    {
        $this->authorize('update', $raffle);

        return view('app.raffles.edit', compact('raffle'));
    }

    /**
     * @param \App\Http\Requests\RaffleUpdateRequest $request
     * @param \App\Models\Raffle $raffle
     * @return \Illuminate\Http\Response
     */
    public function update(RaffleUpdateRequest $request, Raffle $raffle)
    {
        $this->authorize('update', $raffle);

        $validated = $request->validated();

        $raffle->update($validated);

        return redirect()
            ->route('raffles.edit', $raffle)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Raffle $raffle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Raffle $raffle)
    {
        $this->authorize('delete', $raffle);

        $raffle->delete();

        return redirect()
            ->route('raffles.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
