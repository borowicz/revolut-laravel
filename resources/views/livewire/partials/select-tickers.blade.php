
@if(isset($tickers))
    <div class="flex justify-between items-center mb-4 mt-4 float-left">
        @if(isset($tickersName))
            <x-input-label for="selectedTicker" :value="__('when')"/>
        @endif
        <select wire:model.live="selectedTicker"
                name="selectedTicker"
                class="mt-1 block py-2 px-3 border border-gray-300 bg-white rounded-md">
            <option value="">
                @if(isset($txtFirst))
                    {{ $txtFirst }}
                @else
                    {{ __('All') }}
                @endif
            </option>
            @foreach($tickers as $ticker)
                <option value="{{ $ticker }}">{{ $ticker }}</option>
            @endforeach
        </select>
    </div>
    <script>
        // document.addEventListener('livewire:load', function () {
        //     Livewire.on('reloadPage', () => {
        //         location.reload();
        //     });
        // });
    </script>
@endif
