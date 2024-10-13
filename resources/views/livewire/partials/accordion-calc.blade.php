<div class="w-full bg-gray-100 mt-2 ">
    <button class="w-full text-left p-3 font-semibold hover:bg-gray-200"
            onclick="toggleCalc()">{{ __('Calc') }}</button>
    <div id="calc" class="hidden p-1 m-1">
        @include('livewire.revolut.stock.form-calculator')
    </div>
</div>

<script>
    function toggleCalc() {
        const calcElement = document.getElementById('calc');
        calcElement.classList.toggle('hidden');
    }
</script>
