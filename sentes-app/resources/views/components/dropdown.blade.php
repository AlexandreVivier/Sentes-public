<div class="dropdown-container">
    <form action="#" method="get" class="w-25">
        <input type="text"
        name="search"
        class="bg-light search-input"
        placeholder="Rechercher un GN..."
        value="{{ request('search') }}"
        >
    </form>
    <div x-data="{ show: false }" class="w-25" @click.away="show = false">
        <button class="light-button dropdown-toggle" @click="show = !show">
            {{ isset($location) ? ucwords($location->title) : 'Par lieu' }}
            <span class="chevron"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div x-show="show" class="dropdown-list">
            <a href="{{ route('events.index') }}" class="text-green text-normal semi-bold none">Tous les GN</a>
            @foreach ($locations as $location)
                <a href="{{ route('locations.show', $location->id)}}" class="text-green text-normal semi-bold none">
                    {{ $location->title }}
                    <span class="text-small italic"> - {{ $location->zip_code }}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
