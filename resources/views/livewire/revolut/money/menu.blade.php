
@php
$menuItems = [
    // 'name' => 'route.name',
    'money' => 'money.index',
    'transactions' => 'money.transactions',
    'types' => 'money.transactions',
    'year' => 'money.transactions',
    'currency' => 'money.transactions',
    'stat' => 'money.transactions',
//    'tickers' => 'money.tickers',
    'upload' => 'money.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
