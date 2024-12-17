<x-layoutDoom>
    <section class="w-75 flex-col items-center bg-light border-light">
        <h1 class="index-title special-elite-regular">Liste des communautés</h1>
        <h4 class="special-elite-regular">Si tu es auteurice d'une de ces listes, tu peux ici la modifier ou la supprimer.</h4>
        <h4 class="special-elite-regular text-light-green">Attention, cette modification/suppression affectera l'ensemble du site et les personnes / GN qui l'utilisent !</h4>
        @if($communityList->isEmpty())
            <p class="special-elite-regular">Cette liste est vide pour le moment.</p>
        @else
            <ul class="list-none w-50 flex-col">
            @foreach ($communityList as $community)
                <li>
                    <div class="flex-row">
                    <a href="{{ route('communities.list.show', $community->id) }}" class="transparent-button special-elite-regular uppercase w-50">
                        Communautés "{{ $community->name }}" -
                        <span class="special-elite-regular text-small">
                         {{ $community->author->login }}
                        </span>
                    </a>
                    @if($community->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <div class="w-25">
                        <a href="{{ route('communities.list.edit', $community) }}" class="transparent-button special-elite-regular">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                    <form action="{{ route('communities.list.destroy', $community) }}" method="POST" class="w-25">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="transparent-button special-elite-regular w-25">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
                </li>
            @endforeach
        </ul>
        @endif
        <div class="w-75 show-button-container border-top-down-gradient">
            <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular">Retour vers la création de contenus</a>
            <a href="{{ route('communities.list.create') }}" class="green-button special-elite-regular">Créer une nouvelle liste de communautés</a>
            {{-- <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="light-button special-elite-regular">Retour à mes organisations</a> --}}
        </div>
    </section>
</x-layoutDoom>
