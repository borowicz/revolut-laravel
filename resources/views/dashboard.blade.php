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

                    <div class="py-3">

                        <div class="grid grid-cols-2 gap-1">
                            <div>

                                @forelse($items as $key => $value)

                                    <span class="text-xl text-gray-800 leading-tight"
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

                                    <br />
                                    <br />

                                @empty
                                    &nbsp; {{ __('no data') }}&nbsp;<br style="clear: both"/>
                                @endforelse
                            </div>
                            <!-- ... -->
                            <div>
                                <b>{{ __('transactions') }}</b>
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
                                    <hr style="width: 90%">
                                @endif
                            </div>
                            <div class="grid grid-cols-subgrid gap-4 col-span-3">
                                <div class="col-start-2">
{{--                                    {{ __('user') }}:--}}
                                ...
                                </div>
                            </div>
                        </div>

                    </div>

                    <hr/>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
