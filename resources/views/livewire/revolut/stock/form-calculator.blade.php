<div class="w-full text-left font-semibold">
    <div class="p-4">
        <form wire:submit.prevent="submitForm">
            <div style="border: solid 0px red">
                <div class="grid grid-cols-5 gap-4">
                    <div>
                        @php( $selecAtction = [ __('buy'), __('sell')])
                        @include('revolutPartials::selected-tickers', ['txtFirst' => 'select action' , 'tickers' => $selecAtction])
                    </div>
                    <div>
                        @include('revolutPartials::selected-tickers')
                    </div>
                    <div>
                        <x-text-input id="cPrice"
                                      placeholder="{{ __('Price') }}"
                                      name="cPrice"
                                      type="number" step="0.1"
                                      class="w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                    </div>
                    <div>
                        <x-text-input id="cPrice"
                                      placeholder="{{ __('Quantity') }}"
                                      name="cPrice"
                                      type="number"
                                      class="text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                    </div>
                    <div>
                        <x-text-input id="cPrice"
                                      placeholder="{{ __('Value') }}"
                                      name="cPrice"
                                      readonly
                                      class="text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                    </div>
                </div>
                <div class="p-3 col-span-3">
                    <hr/>
                </div>
                <div>
                    <div class="grid grid-cols-5 gap-4">
                        <div class="text-right">
                            {{ __('expected') }}:
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                    </div>
                </div>
                <div class="p-3 col-span-3">
                    <hr/>
                </div>
                <div>
                    <div class="grid grid-cols-5 gap-4">
                        <div class="text-right">
                            {{ __('current values') }}:
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                        <div>
                            <x-text-input id="cPrice"
                                          name="cPrice"
                                          placeholder="current"
                                          readonly
                                          class="bg-gray-200 text-right w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm"/>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Include the JavaScript file only for this form -->
@push('scripts')
    @vite(['resources/js/transaction-form.js'])
@endpush
