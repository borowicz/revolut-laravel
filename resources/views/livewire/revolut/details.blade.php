<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Transaction details') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 text-sm">
                <div class="font-semibold text-xl leading-tight">
                    {{ __('Stock') }}: {{ $ticker }}
                </div>

                <div class="p-6">
                    @foreach($items->toArray() as $key => $val)
                        {{ $key }}: {{ $val }}<br/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
