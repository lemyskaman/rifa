<?php

namespace App\Http\Livewire;

use App\Models\Raffle;
use Livewire\Component;
use App\Models\Terminal;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RaffleTerminalsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Raffle $raffle;
    public Terminal $terminal;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Terminal';

    protected $rules = [
        'terminal.number' => ['required', 'numeric'],
        'terminal.status' => ['required', 'in:available,saved,unavailable'],
        'terminal.price' => ['required', 'numeric'],
    ];

    public function mount(Raffle $raffle)
    {
        $this->raffle = $raffle;
        $this->resetTerminalData();
    }

    public function resetTerminalData()
    {
        $this->terminal = new Terminal();

        $this->terminal->status = 'available';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newTerminal()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.raffle_terminals.new_title');
        $this->resetTerminalData();

        $this->showModal();
    }

    public function editTerminal(Terminal $terminal)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.raffle_terminals.edit_title');
        $this->terminal = $terminal;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if (!$this->terminal->raffle_id) {
            $this->authorize('create', Terminal::class);

            $this->terminal->raffle_id = $this->raffle->id;
        } else {
            $this->authorize('update', $this->terminal);
        }

        $this->terminal->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Terminal::class);

        Terminal::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetTerminalData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->raffle->terminals as $terminal) {
            array_push($this->selected, $terminal->id);
        }
    }

    public function render()
    {
        return view('livewire.raffle-terminals-detail', [
            'terminals' => $this->raffle->terminals()->paginate(20),
        ]);
    }
}
