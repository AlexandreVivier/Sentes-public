<article>
    <form action="{{ route('admin.locations.update', $location->id) }}" method="post">
        @csrf
        @method('PATCH')
            <div class="form-wrapper">

                    <div class="form-input">
                        <label class="text-shadowed" for="title">Nom :</label>
                        <input type="text" name="title" id="title"  value="{{ $location->title }}">
                        @error('title')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="number">Numéro :</label>
                        <input type="text" name="number" id="number" value="{{ $location->number }}">
                        @error('number')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="street">Rue :</label>
                        <input type="text" name="street" id="street"  value="{{ $location->street }}">
                        @error('street')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="zip_code">Code postal :</label>
                        <input type="text" name="zip_code" id="zip_code"  value="{{ $location->zip_code }}">
                        @error('zip_code')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="city_name">Ville :</label>
                        <input type="text" name="city_name" id="city_name"  value="{{ $location->city_name }}">
                        @error('city_name')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="bis">Bis / Ter :</label>
                        <input type="text" name="bis" id="bis"  value="{{ $location->bis }}">
                        @error('bis')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="addon">Complément d'adresse :</label>
                        <input type="text" name="addon" id="addon"  value="{{ $location->addon }}">
                        @error('addon')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

            </div>
            <div class="form-submit">
                <button type="submit" class="green-button special-elite-regular">Enregistrer</button>
            </div>

            <div class="form-submit">
                <a href="{{ route('admin.locations.show', $location->id) }}" class="light-button special-elite-regular">Annuler</a>
            </div>
    </form>
</article>
