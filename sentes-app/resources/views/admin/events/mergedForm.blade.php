
<form method="POST" action="{{ route('admin.events.store') }}" class="form-large" enctype="multipart/form-data">
    @csrf

    @include('components.forms.eventCreate1')
    @include('components.forms.eventCreate2')

    <div class="form-input">
        <input type="hidden" name="author_id" value="{{ Auth::user()->id }}">
    </div>

            <div class="form-input form-multi-button">
                <a href="{{ route('admin.events.index') }}" class="light-button">
                    Retour à la liste
                </a>
                <button type="submit" class="green-button">
                    Créer le GN
                </button>
            </div>
</form>
