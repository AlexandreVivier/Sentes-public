
        <div class="form-input">
            <label for="city" class="text-shadowed">
                Ville :
            </label>
            <input type="text" name="city" id="city" value="{{ $user->city }}">
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
            <p class="text-small italic text-green">
                jpeg, jpg ou png.
            </p>
            @error('avatar_path')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <input type="hidden" name="accepted_terms" value="1">
        </div>

        @if(auth()->user()->is_admin)
        <div class="form-check">
            <label for="is_admin" class="text-shadowed">
                Promouvoir Admin :
            </label>
            <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }}>

            <label for="is_banned" class="text-shadowed">
                Bannir :
            </label>
            <input type="checkbox" name="is_banned" id="is_banned" value="1" {{ $user->is_banned ? 'checked' : '' }}>
        </div>
        @endif

