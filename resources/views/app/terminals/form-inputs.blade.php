@php $editing = isset($terminal) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="number"
            label="Number"
            value="{{ old('number', ($editing ? $terminal->number : '')) }}"
            max="255"
            placeholder="Number"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $terminal->status : '')) @endphp
            <option value="available" {{ $selected == 'available' ? 'selected' : '' }} >Available</option>
            <option value="saved" {{ $selected == 'saved' ? 'selected' : '' }} >Saved</option>
            <option value="unavailable" {{ $selected == 'unavailable' ? 'selected' : '' }} >Unavailable</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="ticket_id" label="Ticket">
            @php $selected = old('ticket_id', ($editing ? $terminal->ticket_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Ticket</option>
            @foreach($tickets as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Price"
            value="{{ old('price', ($editing ? $terminal->price : '')) }}"
            max="255"
            step="0.01"
            placeholder="Price"
            required
        ></x-inputs.number>
    </x-inputs.group>
</div>
