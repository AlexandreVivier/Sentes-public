<div class="user-show">
    <div class="w-100 flex-row justify-center">
    @if($user->avatar_path === 'images/static/blank-profile.png')
    <img src="{{ asset('images/static/blank-profile.png') }}" class="avatar-pict user-photo" alt="{{ $user->login }}"/>
    @else
    <img src="{{ asset('storage/' . $user->avatar_path) }}" class="avatar-pict user-photo" alt="{{ $user->login }}"/>
    @endif
</div>
    @if($user->is_admin || $user->id === auth()->user()->id)
    <h3 class="index-title special-elite-regular">Informations privées :</h3>
    @endif
        <p class="text-green text-center">
            {{ $user->first_name }}
            @if($user->is_admin || $user->id === auth()->user()->id)
            {{ $user->last_name }}
            @endif
            @if ($user->pronouns)
            </br>
            <span class="italic">
                ({{ $user->pronouns }})
            </span>
            @endif
        </p>
        @if ($user->biography)
        <p class="text-light-green italic text-center">
            "{{ $user->biography }}"
        </p>
        @endif
        @if($user->city)
        <p class="text-green">De {{ $user->city }}</p>
        @endif
        <p class="text-green">
        @if ($user->discord_username)
            Discord :
            <span class="semi-bold">
                {{ $user->discord_username }}
            </span>
        @endif
        @if($user->discord_username && $user->facebook_username)
            |
        @endif
        @if ($user->facebook_username)
            Facebook :
            <span class="semi-bold">
                {{ $user->facebook_username }}
            </span>
        @endif
        </p>

        @if($user->is_admin || $user->id === auth()->user()->id)
        <h3 class="index-title special-elite-regular">Informations privées :</h3>
        <p class="text-green">Email :
            <span class="semi-bold">{{ $user->email }}</span>
        </p>
        <p class="text-green">Numéro de téléphone :
            <span class="semi-bold">{{ $user->phone_number }}</span>
        </p>
        <p class= "text-green">Niveau de secourisme :
            <span class="semi-bold">{{ $user->first_aid_qualifications}}</span>
        </p>
        <p class="text-green">Allergies :
            <span class="semi-bold">{{ $user->allergies }}</span>
        </p>
        <p class="text-green">Régime alimentaire :
            <span class="semi-bold">{{ $user->diet_restrictions }}</span>
        </p>
        <p class="text-green">Contact d'urgence :
            <span class="semi-bold">{{ $user->emergency_contact_name }}</span>
        | <span class="semi-bold">{{ $user->emergency_contact_phone_number }}</span>
        </p>
        <p class="text-green">Trigger Warnings / sujets sensibles :
            <span class="semi-bold">{{ $user->trigger_warnings }}</span>
        </p>
        <p class="text-green">Restrictions de personnes :
            <span class="semi-bold">{{ $user->red_flag_people }}</span>
        </p>
        @endif


        <p class="text-green italic">Membre de la communauté depuis le {{ $user->getFormatedDate($user->created_at) }}</p>
</div>
