
@php
$menuItems = [
    // 'name' => 'route.name',
     'summary' => 'stock.index',
     'prices' => 'stock.prices',
     'cash' => 'stock.cash',
     'transactions' => 'stock.transactions',
     'tickers' => 'stock.tickers',
     'markets' => 'stock.markets',
     'upload' => 'stock.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
