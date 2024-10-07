
@php
$menuItems = [
    // 'name' => 'route.name',
    'commodities' => 'commodities.index',
//    'transactions' => 'commodities.transactions',
//    'tickers' => 'commodities.tickers',
    'upload' => 'commodities.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
