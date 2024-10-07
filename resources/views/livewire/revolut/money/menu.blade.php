
@php
$menuItems = [
    // 'name' => 'route.name',
    'money' => 'money.index',
//    'transactions' => 'money.transactions',
//    'tickers' => 'money.tickers',
    'upload' => 'money.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
