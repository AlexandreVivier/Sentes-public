{{--
<form method="POST" action="{{ route('admin.locations.store') }}" class="form-large">
    @csrf
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
            Numéro :
        </label>
        <input type="text" name="number" id="number" value="{{ old('number') }}" required>
        @error('number')
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
 --}}
