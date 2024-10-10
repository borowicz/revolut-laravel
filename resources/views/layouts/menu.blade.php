<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('stock.index')" :active="request()->routeIs('stock.*')">
        {{ __('Stock') }}
    </x-nav-link>
    <x-nav-link :href="route('crypto.index')" :active="request()->routeIs('crypto.*')">
        {{ __('Crypto') }}
    </x-nav-link>
    <x-nav-link :href="route('commodities.index')" :active="request()->routeIs('commodities.*')">
        {{ __('Commodities') }}
    </x-nav-link>
    <x-nav-link :href="route('money.index')" :active="request()->routeIs('money.*')">
        {{ __('Money') }}
    </x-nav-link>
    <x-nav-link :href="route('currency.index')" :active="request()->routeIs('currency.*')">
        {{ __('Currency') }}
    </x-nav-link>
    <x-nav-link :href="route('cron.index')" :active="request()->routeIs('cron.*')">
        {{ __('Cron') }}
    </x-nav-link>
    <x-nav-link :href="route('notes.index')" :active="request()->routeIs('notes.*')">
        {{ __('Notes') }}
    </x-nav-link>
    <x-nav-link href="https://app.revolut.com/start" target="_blank">
        {{ __('Revolut') }}
    </x-nav-link>
    <x-nav-link href="https://trade.revolut.com" target="_blank">
        {{ __('RevolutTrade') }}
    </x-nav-link>
</div>
