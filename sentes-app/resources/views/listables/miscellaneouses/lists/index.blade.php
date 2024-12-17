<x-layoutDoom>
    <section class="w-75 flex-col items-center bg-light border-light">
        <h1 class="index-title special-elite-regular">Listes diverses :</h1>
        <h4 class="special-elite-regular">Si tu es auteurice d'une de ces listes, tu peux ici la modifier ou la supprimer.</h4>
        <h4 class="special-elite-regular text-light-green">Attention, cette modification/suppression affectera l'ensemble du site et les personnes / GN qui l'utilisent !</h4>
        @if($miscellaneousList->isEmpty())
            <p class="special-elite-regular">Cette liste est vide pour le moment.</p>
        @else
            <ul class="list-none w-50 flex-col">
            @foreach ($miscellaneousList as $miscellaneous)
                <li>
                    <div class="flex-row">
                    <a href="{{ route('miscellaneous.list.show', $miscellaneous->id) }}" class="transparent-button special-elite-regular uppercase w-50">
                        "{{ $miscellaneous->name }}"
                        <span class="special-elite-regular text-small">
                        - dans "{{ $miscellaneous->miscellaneousCategory->name }}" par
                         {{ $miscellaneous->author->login }}
                        </span>
                    </a>
                    @if($miscellaneous->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <div class="w-25">
                        <a href="{{ route('miscellaneous.list.edit', $miscellaneous->id) }}" class="transparent-button special-elite-regular">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                    <form action="{{ route('miscellaneous.list.destroy', $miscellaneous->id) }}" method="POST" class="w-25">
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
        <div class="w-100 show-button-container border-top-down-gradient">
            <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular">Retour vers la création de contenus</a>
            <a href="{{ route('miscellaneous.categories.index') }}" class="light-button special-elite-regular">Catégories de listes diverses</a>
                  {{-- </div>
        <div class="w-75 show-button-container">
            <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="light-button special-elite-regular">Retour à mes organisations</a> --}}
            <a href="{{ route('miscellaneous.list.create') }}" class="green-button special-elite-regular">Créer une nouvelle liste diverse</a>
        </div>
    </section>
</x-layoutDoom>
