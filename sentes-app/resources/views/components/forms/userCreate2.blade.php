<h2 class="text-roboto">
    Informations suplémentaires :
</h2>
<div class="form-wrapper">
    <div class="form-col">
        <div class="form-input">
            <label for="city" class="text-shadowed">
                Ville :
            </label>
            <input type="text" name="city" id="city" value="{{ old('city') }}">
            @error('city')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="avatar_path" class="text-shadowed">
                Avatar :
            </label>
            <input type="file" name="avatar_path" id="avatar_path" value="{{ old('avatar_path') }}" accept="image/png, image/jpeg">
            @error('avatar_path')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <input type="hidden" name="accepted_terms" value="1">
        </div>
    </div>
</div>
