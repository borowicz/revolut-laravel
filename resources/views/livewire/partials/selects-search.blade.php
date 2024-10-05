
@include('livewire.partials.pagination')

<!-- Search and Per Page Controls -->
<div class="flex justify-between items-center mb-4 mt-4">
    @include('livewire.partials.select-tickers')

    @if($searchBox)
        <div>
            <input type="text"
                   wire:model.debounce.300ms="search"
                   placeholder="Search products..."
                   class="mt-1 block w-full py-2 px-3
border border-gray-300 bg-white rounded-md shadow-sm
focus:outline-none focus:ring-blue-500 focus:border-blue-500
sm:text-sm"
            />
        </div>
    @endif


    @if(isset($types))
        <div>
        <select wire:model.live="selectedType"
                class="mt-1 block w-full py-2 px-3
border border-gray-300 bg-white rounded-md shadow-sm
focus:outline-none focus:ring-blue-500 focus:border-blue-500
sm:text-sm"
        >
            <option value="">{{ __('All') }}</option>
            @foreach($types as $type)
                <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
        </select>
        </div>
    @endif

    @include('livewire.partials.select-pagination')
</div>
