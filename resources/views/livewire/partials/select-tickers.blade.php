
@if(isset($tickers))
    <div class="flex justify-between items-center mb-4 mt-4 float-left">
        <select wire:model.live="selectedTicker"
                name="selectedTicker"
                class="mt-1 block py-2 px-3
border border-gray-300 bg-white rounded-md shadow-sm
focus:outline-none focus:ring-blue-500 focus:border-blue-500
sm:text-sm">
            <option value="">{{ __('All') }}</option>
            @foreach($tickers as $ticker)
                <option value="{{ $ticker }}">{{ $ticker }}</option>
            @endforeach
        </select>
    </div>
@endif
