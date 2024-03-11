<article>
    <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <h2 class="text-roboto">
            Informations obligatoires :
        </h2>
            <div class="form-wrapper">
                    @include('components.forms.userEdit1')
            </div>

        <h2 class="text-roboto">
            Informations suplémentaires :
        </h2>
            <div class="form-wrapper">
                    @include('components.forms.userEdit2')
            </div>

            <div class="show-button-container">
            <div class="form-input">
                <a href="{{ route('admin.users.index') }}" class="light-button">
                    Retour
                </a>
            </div>

            <div class="form-input">
                <button type="submit" class="green-button">
                    Enregistrer
                </button>
            </div>
        </div>
    </form>

</article>
