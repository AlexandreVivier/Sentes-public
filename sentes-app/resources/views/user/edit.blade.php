<x-layoutLight>
	<section>
		<x-basicFrameHeader>
            <h1 class="special-elite-regular">Modifier mon profil</h1>
        </x-basicFrameHeader>
        <x-basicFrameContent>
            <form action="{{ route('user.edit', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <h2 class="special-elite-regular">
                 Informations obligatoires :
                </h2>
                <div class="form-wrapper">
                    @include('components.forms.userEdit1')
                </div>

                <h2 class="special-elite-regular">
                    Informations supplémentaires :
                </h2>
                <p class="text-small italic text-green">
                    Ces informations seront affichées publiquement sur votre profil.
                </p>

                <div class="form-wrapper">
                    @include('components.forms.userEdit2')
                </div>

                <p class="text-small italic text-green">
                    Ces informations seront affichées uniquement pour les orgas des jeux sur lesquels vous êtes inscrit.e et les admins.
                </p>
                <div class="form-wrapper">
                    @include('components.forms.userEdit3')
                </div>

                <div class="user-button-container">
                    <div class="w-100">
                        <button type="submit" class="green-button special-elite-regular w-100">
                            Enregistrer
                        </button>
                    </div>
                    <div class="w-100">
                        <a href="{{ route('profile.myProfile') }}" class="light-button special-elite-regular w-100">
                            Retour
                        </a>
                    </div>
                </div>
            </form>



        </x-basicFrameContent>
	</section>
</x-layoutLight>

<dialog>
    @include('components.modals.deleteUser')
</dialog>
@include('components.scripts.deleteConfirm')
