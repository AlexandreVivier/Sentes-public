<x-layoutLight>
	<section>
		<x-basicFrameHeader>
            <h1>Modifier mon profil</h1>
        </x-basicFrameHeader>
        <x-basicFrameContent>
            <form action="{{ route('user.edit', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <h2>
                 Informations obligatoires :
                </h2>
                <div class="form-wrapper">
                    @include('components.forms.userEdit1')
                </div>

                <h2>
                    Informations supplémentaires :
                   </h2>

                <div class="form-wrapper">
                    @include('components.forms.userEdit2')
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
            <div class="user-button-container w-75">
                <form action="{{ route('user.delete', $user->id) }}" method="post" class="w-100">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="transparent-button special-elite-regular w-100" id="delete">
                        <span class="text-normal">Supprimer mon compte</span>
                    </button>
                </form>
            </div>


        </x-basicFrameContent>
	</section>
</x-layoutLight>

<dialog>
    @include('components.modals.deleteUser')
</dialog>
@include('components.scripts.deleteConfirm')
