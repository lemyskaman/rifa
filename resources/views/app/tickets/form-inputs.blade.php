@php $editing = isset($ticket) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="Usuario" required>
            @php $selected = old('user_id', ($editing ? $ticket->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="payment_status" label="Estado de Pago">
            @php $selected = old('payment_status', ($editing ? $ticket->payment_status : 'unpaid')) @endphp
            <option value="unpaid" {{ $selected == 'unpaid' ? 'selected' : '' }} >No Pagado</option>
            <option value="partial-paid" {{ $selected == 'partial-paid' ? 'selected' : '' }} >Pago Parcial</option>
            <option value="paid" {{ $selected == 'paid' ? 'selected' : '' }} >Pagado</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $ticket->amount : '')) }}"
            max="255"
            step="0.01"
            placeholder="Amount"
        ></x-inputs.number>
    </x-inputs.group>
</div>
