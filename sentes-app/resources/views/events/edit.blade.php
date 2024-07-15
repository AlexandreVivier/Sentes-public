<x-layoutDoom>
    <div class="bg-light flex-col justify-center w-75 border-light">
        <div class="admin-container">
            <section>
                @if($event->start_date > now())
                <form action="{{ route('event.modify', $event->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                        <h2 class="text-green special-elite-regular">Informations obligatoires :</h2>

                            <article class="form-wrapper">
                                @include('components.forms.eventEdit1')
                            </article>

                        <h2 class="text-green special-elite-regular">Informations optionnelles :</h2>

                            <article class="form-wrapper">
                                @include('components.forms.eventEdit2')
                            </article>

                            <div class="show-button-container">
                                <div class="form-input">
                                    <a href="{{ route('events.show', $event->id) }}" class="light-button special-elite-regular w-100">
                                        Annuler
                                    </a>
                                </div>

                                <div class="form-input">
                                    <button type="submit" class="green-button special-elite-regular w-100">
                                        Enregistrer
                                    </button>
                                </div>
                            </div>
                </form>
                @else
                <form action="{{ route('event.post.date.infos', $event->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                        <h2 class="text-green special-elite-regular">Informations Post-GN :</h2>

                        <article class="form-wrapper">
                            @include('components.forms.eventEdit3')
                        </article>
                        <div class="show-button-container">
                            <div class="form-input">
                                <a href="{{ route('events.show', $event->id) }}" class="light-button special-elite-regular w-100">
                                    Annuler
                                </a>
                            </div>

                            <div class="form-input">
                                <button type="submit" class="green-button special-elite-regular w-100">
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                </form>
            @endif
            </section>
        </div>
    </div>
    <div class="h-70vh"></div>
</x-layoutDoom>
