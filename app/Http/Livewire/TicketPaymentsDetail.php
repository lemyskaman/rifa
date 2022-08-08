<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Payment;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketPaymentsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Ticket $ticket;
    public Payment $payment;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Payment';

    protected $rules = [
        'payment.id' => ['required', 'max:255'],
        'payment.amount' => ['required', 'numeric'],
        'payment.status' => ['required', 'in:'],
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->resetPaymentData();
    }

    public function resetPaymentData()
    {
        $this->payment = new Payment();

        $this->payment->status = '';

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPayment()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.ticket_payments.new_title');
        $this->resetPaymentData();

        $this->showModal();
    }

    public function editPayment(Payment $payment)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.ticket_payments.edit_title');
        $this->payment = $payment;

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

        if (!$this->payment->ticket_id) {
            $this->authorize('create', Payment::class);

            $this->payment->ticket_id = $this->ticket->id;
        } else {
            $this->authorize('update', $this->payment);
        }

        $this->payment->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Payment::class);

        Payment::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPaymentData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->ticket->payments as $payment) {
            array_push($this->selected, $payment->id);
        }
    }

    public function render()
    {
        return view('livewire.ticket-payments-detail', [
            'payments' => $this->ticket->payments()->paginate(20),
        ]);
    }
}
