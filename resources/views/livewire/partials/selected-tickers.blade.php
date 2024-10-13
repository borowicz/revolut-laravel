
{{--@props(['tickers', 'selectedTicker', 'tickersName' => null])--}}
{{--@php($tickerValue = 'BAM')--}}
@if($tickers)
        @if(isset($tickersName))
            <x-input-label for="tickerSelected" :value="__($tickersName)"/>
        @endif

        <select name="tickerSelected"
                class="w-full block p-3 border border-gray-300 bg-white rounded-md shadow-sm sm:text-sm">
            <option value="">
                @if(isset($txtFirst))
                    {{ $txtFirst }}
                @else
                    {{ __('All') }}
                @endif
            </option>
            @foreach($tickers as $ticker)
                <option value="{{ $ticker }}" {{ $ticker == ($tickerValue ?? '') ? 'selected' : '' }}>
                    {{ $ticker }}
                </option>
            @endforeach
        </select>
@endif
