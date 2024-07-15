<section>
    <form action="{{ route('admin.events.update', $event->id) }}" method="post" enctype="multipart/form-data">
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

            <h2 class="text-green special-elite-regular">Informations post-GN :</h2>

            <article class="form-wrapper">
                @include('components.forms.eventEdit3')
            </article>
            <div class="show-button-container">

            <div class="form-input">
                <a href="{{ route('admin.events.show', $event->id) }}" class="light-button special-elite-regular w-100">
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
</section>
