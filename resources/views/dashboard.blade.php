<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Revolut Laravel Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Revolut DB summary") }}:
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-sm">
                    @if ($user ?? false)
                        {{ __('user') }}: <span title="{{ $user['email'] }}">{{ $user['name'] ?? '' }}</span>
                        {{ __('logged') }}: <span>{{ $user['sessionTime'] ?? '' }}</span>
                    @endif
                    <br class="clear-both">
                    @forelse($items as $model => $item)
                        <div>
                        <b title="{{ $model }}">{{ $item['name'] }}</b>:

                        @forelse($item['info'] as $key => $value)
                            @if (is_array($value))
                                {{ __($key) }}:
                                @foreach($value as $k => $v)
                                    <br /><b>{{ __($k) }}</b>: {{ $v }},&nbsp;
                                @endforeach
                            @else
                                <br /><b>{{ __($key) }}</b>: {{ $value }},&nbsp;
                            @endif
                        @empty
                            &nbsp;
                        @endforelse

                        @if(isset($item['stats']))
                            <hr style="color: red">
                            @forelse($item['stats'] as $stat => $stats)
                                    <b>{{ __($stat) }}</b>:
                                @if(is_array($stats))
                                    @foreach($stats as $s => $sVal)
                                        <br/>&nbsp;&nbsp;&nbsp;&nbsp;{{ __($s) }}:&nbsp;{{ $sVal }}
                                    @endforeach
                                    <br/>
                                @else
                                    &nbsp;{{ $stats }}<br/>
                                @endif
                            @empty
                                &nbsp;
                            @endforelse
                        @endif

                        </div>
                        <hr /><br class="clear: both" />
                    @empty
                        {{ __('No summary data') }}.
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
