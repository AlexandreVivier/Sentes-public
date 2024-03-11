
    <div class="form-col">

        <div class="form-input">
            <label for="login" class="text-shadowed">
                Pseudo :
            </label>
            <input type="text" name="login" id="login" value="{{ $user->login }}" required>
            <p class="text-small italic text-green">
                Le pseudo doit être unique, et faire au moins 3 caractères de long.
            </p>
            @error('login')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="first_name" class="text-shadowed">
                Prénom :
            </label>
            <input type="text" name="first_name" id="first_name" value="{{ $user->first_name }}" required>
            @error('first_name')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

    </div>
    <div class="form-col">

        <div class="form-input">
            <label for="email" class="text-shadowed">
                Email :
            </label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" required>
            <p class="text-small italic text-green">
                L'email doit être unique.
            </p>
            @error('email')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="last_name" class="text-shadowed">
                Nom :
            </label>
            <input type="text" name="last_name" id="last_name" value="{{ $user->last_name }}" required>
            @error('last_name')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>


        <div class="form-input">
            <input type="hidden" name="password" id="password" value="{{ $user->password }}" required>
            @error('password')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        {{-- <div class="form-input">
            <input type="hidden" name="password_confirmation" id="password_confirmation"  required>
            @error('password_confirmation')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div> --}}
    </div>






