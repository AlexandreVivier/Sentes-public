<x-layoutDoom>
    <section>
        <x-basicFrameContent>


<form method="POST" action="{{ route('admin.locations.store') }}" class="form-large">
    @csrf

    <h2 class="special-elite-regular">
        Ajouter un lieu à la liste :
    </h2>

    <div class="form-wrapper">
        <div class="form-col">

            <div class="form-input">
                <label for="title" class="text-shadowed">
                    Nom :
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
                @error('title')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="number" class="text-shadowed">
                    Numéro de rue :
                </label>
                <input type="text" name="number" id="number" value="{{ old('number') }}" required>
                @error('number')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="form-input">
                <label for="bis" class="text-shadowed">
                    Bis/Ter ?
                </label>
                <input type="text" name="bis" id="bis" value="{{ old('bis') }}" placeholder="(Optionnel)">
                @error('bis')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="form-input">
                <label for="street" class="text-shadowed">
                    Rue :
                </label>
                <input type="text" name="street" id="street" value="{{ old('street') }}" required>
                @error('street')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>

        </div>
        <div class="form-col">

            <div class="form-input">
                <label for="addon" class="text-shadowed">
                    Complément d'adresse :
                </label>
                <input type="text" name="addon" id="addon" value="{{ old('addon') }}" placeholder="(Optionnel)">
                @error('addon')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="form-input">
                <label for="zip_code" class="text-shadowed">
                    Code postal :
                </label>
                <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" required>
                @error('zip_code')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="form-input">
                <label for="city_name" class="text-shadowed">
                    Ville :
                </label>
                <input type="text" name="city_name" id="city_name" value="{{ old('city_name') }}" required>
                @error('city_name')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>

        </div>
    </div>

    <div class="form-input form-multi-button">
        <a href="{{ route('admin.locations.index') }}" class="light-button special-elite-regular">
            Retour à la liste
        </a>
        <button type="submit" class="green-button special-elite-regular">
            Créer le lieu
        </button>
    </div>

</form>

</x-basicFrameContent>
</section>
</x-layoutDoom>
