<div class="w-full">
    @foreach (['Section 1', 'Section 2', 'Section 3'] as $index => $section)
        <div class="border-b">
            <button
                class="w-full text-left p-4 font-semibold bg-gray-100 hover:bg-gray-200"
                wire:click="toggle({{ $index }})">
                {{ $section }}
            </button>

            @if ($activeIndex === $index)
                <div class="p-4 bg-white">
                    <p>This is the content for {{ $section }}.</p>
                </div>
            @endif
        </div>
    @endforeach
</div>
