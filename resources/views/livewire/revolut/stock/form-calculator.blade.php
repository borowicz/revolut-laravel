<div class="py-12">

    <div class="p-6 text-gray-900 px-4">
        <header>
            <p class="mt-1 text-sm text-gray-600">
                ...
            </p>
        </header>

        <form wire:submit.prevent="submitForm">
        </form>

        <form wire:submit.prevent="save" class="mt-6 space-y-6">

                <div class="grid grid-cols-4 gap-1">
                    <div>
                        <label for="action">Action:</label>
                        <select id="action"
                                wire:model="action"
                                class="mt-3
border border-gray-300 bg-white rounded-md shadow-sm
focus:outline-none focus:ring-blue-500 focus:border-blue-500
sm:text-sm">
                            <option value="buy">Buy</option>
                            <option value="sell">Sell</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit">Submit</button>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-1">
                    <div><x-input-label for="date" :value="__('when')"/>
                        <x-text-input wire:model="date"
                                      id="date"
                                      name="date"
                                      type="text"
                                      value="{{ $date ?? '' }}"
                                      readonly="readonly"
                                      class="mt-1 block w-full bg-gray-100 text-black"/>
                        <x-input-error class="mt-2" :messages="$errors->get('date')"/>
                    </div>
                    <div>
                        @php($tickersName = 'sadsad')
                        @include('revolutPartials::select-tickers')
                    </div>
                    <div><x-input-label for="quantity" :value="__('when')"/>
                        <x-text-input wire:model="quantity"
                                      id="quantity"
                                      name="quantity"
                                      type="text"
                                      value="{{ $date ?? '' }}"
                                      class="mt-1 block w-full text-black"/>
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')"/>
                    </div>
                    <div class="text-center px-5"><x-input-label for="quantity" :value="__('when')"/>
                        <x-text-input wire:model="quantity"
                                      id="quantity"
                                      name="quantity"
                                      type="number"
                                      value="{{ $date ?? '' }}"
                                      class="mt-1 block w-3/4 text-black text-center"/>
                        <x-input-error class="mt-2" :messages="$errors->get('quantity')"/>
                    </div>
                </div>


        </form>
    </div>

</div>



<!-- Include the JavaScript file only for this form -->
@push('scripts')
    @vite(['resources/js/transaction-form.js'])
@endpush
