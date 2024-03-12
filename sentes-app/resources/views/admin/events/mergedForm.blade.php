
<form method="POST" action="{{ route('admin.events.store') }}" class="form-large" enctype="multipart/form-data">
    @csrf

    @include('components.forms.eventCreate1')
    @include('components.forms.eventCreate2')


            <div class="form-input form-multi-button">
                <a href="{{ route('admin.events.index') }}" class="light-button special-elite-regular">
                    Retour à la liste
                </a>
                <button type="submit" class="green-button special-elite-regular">
                    Créer le GN
                </button>
            </div>
</form>
