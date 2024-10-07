
@php
$menuItems = [
    // 'name' => 'route.name',
    'summary' => 'crypto.index',
    'transactions' => 'crypto.transactions',
    'tickers' => 'crypto.tickers',
    'upload' => 'crypto.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
