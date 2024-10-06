
<div class="flex justify-between items-center mb-4 mt-4 float-right">
    <select wire:model.live="perPage"
            name="perPage"
            class="mt-1 block py-2 px-3
border border-gray-300 bg-white rounded-md shadow-sm
focus:outline-none focus:ring-blue-500 focus:border-blue-500
sm:text-sm"

            >
        @foreach([10, 20, 30, 50, 100, 1000] as $v)
            <option value="{{ $v }}">{{ $v }} {{ __('per page') }}</option>
        @endforeach
        <option value="">{{ __('All') }}</option>
    </select>
</div>
