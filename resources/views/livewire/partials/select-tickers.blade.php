
@if(isset($tickers))
    <div>
        <select wire:model.live="selectedTicker"
                class="mt-1 block w-full py-2 px-3
border border-gray-300 bg-white rounded-md shadow-sm
focus:outline-none focus:ring-blue-500 focus:border-blue-500
sm:text-sm"
        >
            <option value="">{{ __('All') }}</option>
            @foreach($tickers as $ticker)
                <option value="{{ $ticker }}">{{ $ticker }}</option>
            @endforeach
        </select>
    </div>
@endif
