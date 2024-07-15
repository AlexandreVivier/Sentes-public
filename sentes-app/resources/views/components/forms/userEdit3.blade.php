<div class="form-input">
    <label for="phone_number" class="text-shadowed">
        Numéro de téléphone :
    </label>
    <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number }}">
    @error('phone_number')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="diet_restrictions" class="text-shadowed">
        Restrictions alimentaires :
    </label>
    <input type="text" name="diet_restrictions" id="diet_restrictions" value="{{ $user->diet_restrictions }}">
    @error('diet_restrictions')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="allergies" class="text-shadowed">
        Allergies :
    </label>
    <input type="text" name="allergies" id="allergies" value="{{ $user->allergies }}">
    @error('allergies')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="medical_conditions" class="text-shadowed">
        Handicaps ou problèmes de santé connus :
    </label>
    <input type="text" name="medical_conditions" id="medical_conditions" value="{{ $user->medical_conditions }}">
    @error('medical_conditions')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="emergency_contact_name" class="text-shadowed">
        Nom du contact d'urgence :
    </label>
    <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ $user->emergency_contact_name }}">
    @error('emergency_contact_name')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="emergency_contact_phone_number" class="text-shadowed">
        Numéro de téléphone du contact d'urgence :
    </label>
    <input type="text" name="emergency_contact_phone_number" id="emergency_contact_phone_number" value="{{ $user->emergency_contact_phone_number }}">
    @error('emergency_contact_phone_number')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="red_flags_people" class="text-shadowed">
        Personnes à éviter :
    </label>
    <input type="text" name="red_flags_people" id="red_flags_people" value="{{ $user->red_flags_people }}">
    @error('red_flags_people')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="trigger_warnings" class="text-shadowed">
        TW & Sujets à éviter dans le GN :
    </label>
    <input type="text" name="trigger_warnings" id="trigger_warnings" value="{{ $user->trigger_warnings }}">
    @error('trigger_warnings')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-input">
    <label for="first_aid_qualifications" class="text-shadowed">
        Qualifications en premiers soins :
    </label>
    <input type="text" name="first_aid_qualifications" id="first_aid_qualifications" value="{{ $user->first_aid_qualifications }}">
    @error('first_aid_qualifications')
    <p>
        {{ $message }}
    </p>
    @enderror
</div>


