<x-layoutDoom>
    <section class="w-75 flex-col items-center bg-light border-light">
        <h1 class="index-title special-elite-regular">Liste de backgrounds :</h1>
        <h4 class="special-elite-regular">Si tu es auteurice d'une de ces listes, tu peux ici la modifier ou la supprimer.</h4>
        <h4 class="special-elite-regular text-light-green">Attention, cette modification/suppression affectera l'ensemble du site et les personnes / GN qui l'utilisent !</h4>
        @if($backgroundList->isEmpty())
            <p class="special-elite-regular">Cette liste est vide pour le moment.</p>
        @else
            <ul class="list-none w-50 flex-col">
                @foreach ($backgroundList as $background)
                    <li>
                        <div class="flex-row">
                            <a href="{{ route('backgrounds.list.show', $background->id) }}" class="transparent-button special-elite-regular uppercase w-50">
                                Backgrounds "{{ $background->name }}" -
                                <span class="special-elite-regular text-small">
                                {{ $background->author->login }}
                                </span>
                            </a>
                            @if($background->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                                <div class="w-25">
                                    <a href="{{ route('backgrounds.list.edit', $background->id) }}" class="transparent-button special-elite-regular">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                                <form action="{{ route('backgrounds.list.destroy', $background->id) }}" method="POST" class="w-25">
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
            {{-- <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="light-button special-elite-regular">Retour à mes organisations</a> --}}
            <a href="{{ route('backgrounds.list.create') }}" class="green-button special-elite-regular">Créer une nouvelle liste de backgrounds</a>
        </div>
    </section>
</x-layoutDoom>
