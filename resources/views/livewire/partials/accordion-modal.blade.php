@php $activeIndex = 0 @endphp

<div class="w-full">
    @foreach (['Section 1', 'Section 2', 'Section 3'] as $index => $section)
        <div class="border-b">
            <button
                class="w-full text-left p-4 font-semibold bg-gray-100 hover:bg-gray-200"
{{--                wire:click="toggle({{ $index }})"--}}
                onclick="openModal()">
                {{ $section }}
            </button>
        </div>
    @endforeach

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
            <button class="text-right text-gray-500 hover:text-gray-700" onclick="closeModal()">
                &times;
            </button>

            @if ($activeIndex !== null)
                <h2 class="text-xl font-semibold mb-4">{{ ['Section 1', 'Section 2', 'Section 3'][$activeIndex] }}</h2>
                <p>This is the content for {{ ['Section 1', 'Section 2', 'Section 3'][$activeIndex] }}.</p>
            @endif
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        window.addEventListener('closeModalEvent', event => {
            closeModal();
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('modal')) {
                closeModal();
            }
        }
    </script>
</div>
