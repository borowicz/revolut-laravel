
@php
$menuItems = [
    // 'name' => 'route.name',
     'summary' => 'stock.index',
     'prices' => 'stock.prices',
     'cash' => 'stock.cash',
     'transactions' => 'stock.transactions',
     'markets' => 'stock.markets',
     'tickers' => 'stock.tickers',
     'upload' => 'stock.upload',
];
@endphp

@foreach($menuItems as $menuText => $menuRoute)

    <a href="{{ route($menuRoute) }}"
       class="inline-flex items-center px-4 py-2 rounded-md
              font-semibold text-xs text-white uppercase
{{ url()->current() == route($menuRoute) ? ' bg-gray-500' : ' bg-gray-800' }}
              active:bg-gray-500 active:text-gray-700
              hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100
              transition ease-in-out duration-150">{{ __($menuText) }}</a>

@endforeach
