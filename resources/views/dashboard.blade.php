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
                        {{ __('Revolut DB summary') }}:
                    </div>

{{--                    @if ($user ?? false)--}}
{{--                        {{ __('user') }}: <span title="{{ $user['email'] }}">{{ $user['name'] ?? '' }}</span>--}}
{{--                        {{ __('logged') }}: <span>{{ $user['sessionTime'] ?? '' }}</span>--}}
{{--                    @endif--}}

                    <div class="py-3">
                        <div class="grid grid-cols-2 gap-1">
                            <div class="p-2 m-2">
                                @if (isset($info))
                                    <b class="uppercase">{{ __('latest update') }}</b>:<br/>
                                    @foreach ($info as $infoKey => $infoValue)
                                        <span class="text-xm text-gray-800 leading-tight"
                                              title="{{ $infoKey }}">{{ $infoValue }} - {{ $infoKey }}</span><br/>
                                    @endforeach
                                    <br/>
                                    <hr/><br/>
                                @endif

                                <b class="uppercase">{{ __('transactions') }}</b>
                                @if(isset($stats))
                                    <br>
                                    @forelse($stats as $stat => $s)
                                        <b>{{ __($stat) }}</b>:
                                        @if(is_array($s))
                                            @foreach($s as $k => $sVal)
                                                <br/>&nbsp;&nbsp;&nbsp;&nbsp;{{ __($k) }}:
                                                &nbsp;{!! $sVal !!}
                                            @endforeach
                                            <br/>
                                        @else
                                            &nbsp;{{ $s }}<br/>
                                        @endif
                                    @empty
                                        &nbsp;
                                    @endforelse
                                    <hr>
                                @endif
                            </div>

                            <div class="p-2 m-2">
                                <b class="uppercase">{{ __('tables') }}</b><br>
                                @forelse($items as $key => $value)
                                    <span class="text-md text-gray-800"
                                          title="{{ $key }}">{{ $value['name'] }}</span>:
                                    @if (is_array($value['info']))
                                        @foreach($value['info'] as $k => $v)
                                            @if (is_array($v))
                                                @foreach($v as $k1 => $v1)
                                                    <br/><b>{{ __($k1) }}</b>: {{ $v1 }},&nbsp;
                                                @endforeach
                                            @else
                                                <br/><b>{{ __($k) }}</b>: {{ $v }},&nbsp;
                                            @endif
                                        @endforeach
                                    @else
                                        <br/><b>{{ __($k) }}</b>: {{ $v }},&nbsp;
                                    @endif
                                    <br class="mb-2"/>
                                @empty
                                    &nbsp; {{ __('no data') }}&nbsp;<br style="clear: both"/>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
