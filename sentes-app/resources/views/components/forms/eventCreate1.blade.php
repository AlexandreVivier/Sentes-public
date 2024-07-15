<h2 class="special-elite-regular">
    Informations obligatoires :
</h2>

<div class="form-wrapper">
    <div class="form-input">
        <label for="title" class="text-shadowed">
            Nom du GN :
        </label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required>
        <p class="text-small italic text-green">
            99 caractères max.
        </p>
        @error('title')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>
    <div class="form-input">
        <label for="description" class="text-shadowed">
            Entête :
        </label>
        <input type="text" name="description" id="description" value="{{ old('description') }}" placeholder="Ton texte sera automatiquement mis entre guillemets et figurera dans le bandeau du jeu." required>
        <p class="text-small italic text-green">
            99 caractères max.
        </p>
        @error('description')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>
    <div class="form-input">
        <label for="start_date" class="text-shadowed">
            Date de début du GN :
        </label>
        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
        @error('start_date')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>
    <div class="form-input">
        <label for="location_id" class="text-shadowed">
            Choisis un lieu :
        </label>
        <select name="location_id" id="location_id" required>
            <option value="">
                - Liste des lieux -
            </option>

            @foreach ($locations as $location)
            <option value="{{ $location->id }}" {{ old('location_id') === $location->id ? 'selected' : '' }}>
                {{ $location->title }}
            </option>
            @endforeach

        </select>
        @error('location_id')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>
</div>
