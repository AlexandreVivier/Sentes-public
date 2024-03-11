<h2 class="text-roboto">
    Informations obligatoires :
</h2>
<div class="form-wrapper">
    <div class="form-col">

        <div class="form-input">
            <label for="login" class="text-shadowed">
                Pseudo :
            </label>
            <input type="text" name="login" id="login" value="{{ old('login') }}" required>
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
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
            @error('first_name')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="last_name" class="text-shadowed">
                Nom :
            </label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
            @error('last_name')
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
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
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
            <label for="password" class="text-shadowed">
                Mot de passe :
            </label>
            <input type="password" name="password" id="password" required>
            @error('password')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-input">
            <label for="password_confirmation" class="text-shadowed">
                Confirmer le mot de passe :
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <p class="text-small italic text-green">
                Le mot de passe doit faire entre 10 et 25 caractères de long, inclure une majuscule, une minuscule, un chiffre et un caractère spécial.
            </p>
            @error('password_confirmation')
            <p>
                {{ $message }}
            </p>
            @enderror
        </div>
    </div>
</div>





