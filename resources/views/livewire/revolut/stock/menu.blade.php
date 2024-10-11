
@php
$menuItems = [
    // 'name' => 'route.name',
     'summary' => 'stock.index',
     'prices' => 'stock.prices',
     'transactions' => 'stock.transactions',
     'top up' => 'stock.cash',
     'money' => 'stock.cash.flow',
     'tickers' => 'stock.tickers',
     'markets' => 'stock.markets',
     'upload' => 'stock.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
