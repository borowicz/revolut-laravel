<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Revolut Laravel Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    <div class="font-semibold text-xl leading-tight">
                        {{ __("Revolut DB summary") }}:
                    </div>
                    @if ($user ?? false)
                        {{ __('user') }}: <span title="{{ $user['email'] }}">{{ $user['name'] ?? '' }}</span>
                        {{ __('logged') }}: <span>{{ $user['sessionTime'] ?? '' }}</span>
                    @endif

                    @forelse($items as $model => $item)
                        <div class="py-3">
                            <span class="text-xl text-gray-800 leading-tight" title="{{ $model }}">{{ $item['name'] }}</span>:

                            @if(isset($item['stats']))
                                <br>
                                @forelse($item['stats'] as $stat => $stats)
                                    <b>{{ __($stat) }}</b>:
                                    @if(is_array($stats))
                                        @foreach($stats as $s => $sVal)
                                            <br/>&nbsp;&nbsp;&nbsp;&nbsp;{{ __($s) }}:&nbsp;{!! $sVal !!}
                                        @endforeach
                                        <br/>
                                    @else
                                        &nbsp;{{ $stats }}<br/>
                                    @endif
                                @empty
                                    &nbsp;
                                @endforelse
                                <hr style="width: 90%">
                            @endif

                            @forelse($item['info'] as $key => $value)
                                @if (is_array($value))
                                    {{ __($key) }}:
                                    @foreach($value as $k => $v)
                                        <br/><b>{{ __($k) }}</b>: {{ $v }},&nbsp;
                                    @endforeach
                                @else
                                    <br/><b>{{ __($key) }}</b>: {{ $value }},&nbsp;
                                @endif
                            @empty
                                &nbsp; {{ __('no data') }}&nbsp;<br style="clear: both"/>
                            @endforelse
                        </div>
                        <hr/>
                    @empty
                        {{ __('No summary data') }}.
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
