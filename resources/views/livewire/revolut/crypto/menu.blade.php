


@foreach($menuItems as $menuText => $menuRoute)

    @include('livewire.partials.sub-menu-button', ['menuRoute' => $menuRoute, 'menuText' => $menuText])

@endforeach
