<x-layoutDoom>
    <section>
        <x-basicFrameContent>

            <form action="{{ route('admin.users.store') }}" method="post" class="form-large" enctype="multipart/form-data">
                @csrf

                @include('components.forms.userCreate1')
                @include('components.forms.userCreate2')

                <div class="form-check">
                    <label for="is_admin" class="text-shadowed">
                        Est-ce un·e admin ?
                    </label>
                    <input type="checkbox" name="is_admin" id="is_admin" value="1" @if(old('is_admin')) checked @endif>
                    @error('is_admin')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="form-input">
                    <p class="text-green italic"> La personne ainsi enregistrée sera considérée comme ayant accepté les conditions générales d'utilisation du site.</p>
                </div>
                <div class="form-input form-multi-button">
                    <a href="{{ route('admin.users.index') }}" class="light-button">Retour à la liste</a>
                    <button type="submit" class="green-button">Enregistrer la personne</button>
                </div>

            </form>

        </x-basicFrameContent>
    </section>
</x-layoutDoom>
