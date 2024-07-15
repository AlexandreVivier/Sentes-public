<x-layoutDoom>
    <main class="event-frame-content bg-light border-light text-green">
<h1 class="text-green special-elite-regular text-center">{{ $event->title }} - Gestion des participations</h1>
    <section class="w-75">
        <article class="attendees-manage-pictos">
<ul class="list-none">
    <li><h3 class="special-elite-regular text-green">Pictogrammes : </h3></li>
    <li><i class="fa-solid fa-user"></i> : Orga</li>
    <li><i class="fa-regular fa-user"></i> : Participant·e</li>
    <li><i class="fa-solid fa-euro"></i> : A payé</li>
    <li><i class="fa-solid fa-masks-theater"></i> : A un personnage</li>
    <li><i class="fa-solid fa-ghost"></i> : Figurant·e</li>
    <li><i class="fa-solid fa-briefcase-medical"></i> : Secouriste</li>
    <li><i class="fa-solid fa-music"></i> : Participe à la chorale</li>
</ul>

<ul class="list-none">
    <li class="flex-row"><h3 class="special-elite-regular text-green">Boutons : </h3></li>
    <li class="flex-row"><span class="light-button chip"><i class="fa-solid fa-user"></i></span> Promouvoir orga</li>
    <li class="flex-row"><span class="light-button chip"><i class="fa-regular fa-user"></i></span> Quitter l'orga</li>
    <li class="flex-row"><span class="light-button chip"><i class="fa-solid fa-euro"></i></span> Changer en "A payé"</li>
    <li class="flex-row"><span class="light-button chip"><i class="fa-brands fa-creative-commons-nc-eu"></i></span> Changer en "N'a pas payé"</li>
</ul>
</article>

<h3 class="text-green special-elite-regular">Inscrit·es : {{ $event->attendee_count }} / {{ $event->max_attendees }}</h3>
<ul class="event-attendees-manage">
    @if ($event->attendees->isNotEmpty())
        @foreach ($event->getSubscribedAttendeesInfosInArray() as $attendee)
                @if ($attendee['is_organizer'])
                <li x-data="{ show: false }" @click.away="show = false">
                    <div class="attendee-manage">
                        <p @click="show = !show" class="text-green special-elite-regular event-link link none semi-bold">
                            <i class="fa-solid fa-user"></i>{{ $attendee['login'] }}
                            @if ($attendee['has_paid'])
                                <i class="fa-solid fa-euro"></i>
                            @endif
                            @if ($attendee['in_choir'])
                                <i class="fa-solid fa-music"></i>
                            @endif
                            @if ($attendee['first_aid_qualifications'])
                                <i class="fa-solid fa-briefcase-medical"></i>
                            @endif
                        </p>

                        <div class="attendee-manage-buttons">
                            @if ($attendee['id'] === auth()->user()->id)
                                <button type="submit" class="light-button chip" id="demoteSelf"><i class="fa-regular fa-user"></i></button>
                            @endif
                            <form method="POST" action="{{ route('event.attendees.set.payment.status', $event->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id" value="{{ $attendee['id'] }}">
                                <input type="hidden" name="has_paid" value="{{ $attendee['has_paid'] ? 0 : 1 }}">
                                <button type="submit" class="light-button chip">
                                    @if ($attendee['has_paid'])
                                        <i class="fa-brands fa-creative-commons-nc-eu"></i>
                                    @else
                                        <i class="fa-solid fa-euro"></i>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    <div x-show="show" class="attendee-manage-infos">
                            <a href="{{ route('profile.show', $attendee['id']) }}" class="transparent-button special-elite-regular">Voir le profil</a>
                            <p class="text-green text-normal semi-bold none">Nom complet :
                                <span class="italic normal-weight">{{ $attendee['first_name'] }} {{ $attendee['last_name'] }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Pronoms :
                                <span class="italic normal-weight">{{ isset($attendee['pronouns'])? $attendee['pronouns'] : 'Non renseignés' }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Téléphone :
                                <span class="italic normal-weight">{{ isset($attendee['phone_number']) ? $attendee['phone_number'] : 'Non renseigné' }}</span>
                            </p>
                            @if ($attendee['first_aid_qualifications'])
                            <p class="text-green text-normal semi-bold none">
                                Qualifications de secourisme :
                                <span class="italic normal-weight">{{ $attendee['first_aid_qualifications'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['emergency_contact_name'])
                            <p class="text-green text-normal semi-bold none">
                                Contact d'urgence :
                                <span class="italic normal-weight">{{ $attendee['emergency_contact_name'] }} au {{ $attendee['emergency_contact_phone_number'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['allergies'])
                            <p class="text-green text-normal semi-bold none">
                                Allergies :
                                <span class="italic normal-weight">{{ $attendee['allergies'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['medical_conditions'])
                            <p class="text-green text-normal semi-bold none">
                                Conditions médicales :
                                <span class="italic normal-weight">{{ $attendee['medical_conditions'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['diet_restrictions'])
                            <p class="text-green text-normal semi-bold none">
                                Restrictions alimentaires :
                                <span class="italic normal-weight">{{ $attendee['diet_restrictions'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['red_flag_people'])
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de personnes :
                                <span class="italic normal-weight">{{ $attendee['red_flag_people'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['trigger_warnings'])
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de sujets :
                                <span class="italic normal-weight">{{ $attendee['trigger_warnings'] }}</span>
                            </p>
                            @endif
                    </div>
                </li>
                @else

                <li x-data="{ show: false }" @click.away="show = false">
                    <div class="attendee-manage">
                        <p @click="show = !show" class="text-green special-elite-regular event-link link none">
                            <i class="fa-regular fa-user"></i>{{ $attendee['login'] }}
                            @if ($attendee['has_paid'])
                                <i class="fa-solid fa-euro"></i>
                            @endif
                            @if ($attendee['in_choir'])
                                <i class="fa-solid fa-music"></i>
                            @endif
                            @if ($attendee['first_aid_qualifications'])
                                <i class="fa-solid fa-briefcase-medical"></i>
                            @endif
                        </p>

                        <div class="attendee-manage-buttons">
                            <button class="light-button chip" id="promoteOrga"><i class="fa-solid fa-user"></i></button>
                            <form method="POST" action="{{ route('event.attendees.set.payment.status', $event->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id" value="{{ $attendee['id'] }}">
                                <input type="hidden" name="has_paid" value="{{ $attendee['has_paid'] ? 0 : 1 }}">
                                <button type="submit" class="light-button chip">
                                    @if ($attendee['has_paid'])
                                        <i class="fa-brands fa-creative-commons-nc-eu"></i>
                                    @else
                                        <i class="fa-solid fa-euro"></i>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    <div x-show="show" class="attendee-manage-infos">
                            <a href="{{ route('profile.show', $attendee['id']) }}" class="transparent-button special-elite-regular">Voir le profil</a>
                            <p class="text-green text-normal semi-bold none">Nom complet :
                                <span class="italic normal-weight">{{ $attendee['first_name'] }} {{ $attendee['last_name'] }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Pronoms :
                                <span class="italic normal-weight">{{ isset($attendee['pronouns'])? $attendee['pronouns'] : 'Non renseignés' }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Téléphone :
                                <span class="italic normal-weight">{{ isset($attendee['phone_number']) ? $attendee['phone_number'] : 'Non renseigné' }}</span>
                            </p>
                            @if ($attendee['first_aid_qualifications'])
                            <p class="text-green text-normal semi-bold none">
                                Qualifications de secourisme :
                                <span class="italic normal-weight">{{ $attendee['first_aid_qualifications'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['emergency_contact_name'])
                            <p class="text-green text-normal semi-bold none">
                                Contact d'urgence :
                                <span class="italic normal-weight">{{ $attendee['emergency_contact_name'] }} au {{ $attendee['emergency_contact_phone_number'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['allergies'])
                            <p class="text-green text-normal semi-bold none">
                                Allergies :
                                <span class="italic normal-weight">{{ $attendee['allergies'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['medical_conditions'])
                            <p class="text-green text-normal semi-bold none">
                                Conditions médicales :
                                <span class="italic normal-weight">{{ $attendee['medical_conditions'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['diet_restrictions'])
                            <p class="text-green text-normal semi-bold none">
                                Restrictions alimentaires :
                                <span class="italic normal-weight">{{ $attendee['diet_restrictions'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['red_flag_people'])
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de personnes :
                                <span class="italic normal-weight">{{ $attendee['red_flag_people'] }}</span>
                            </p>
                            @endif
                            @if ($attendee['trigger_warnings'])
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de sujets :
                                <span class="italic normal-weight">{{ $attendee['trigger_warnings'] }}</span>
                            </p>
                            @endif
                    </div>
                </li>
            @endif
        @endforeach
    @endif
</ul>
<h3 class="special-elite-regular italic text-light-green">Désistements :</h3>
        <ul class="event-attendees-manage">
            @foreach ($event->getUnsubscribedAttendeesInfosInArray() as $attendee)
                <li class="attendee-manage">
                    <a href=" {{ route('profile.show', $attendee['id']) }}" class="text-light-green special-elite-regular event-link italic link none">
                        @if ($attendee['is_organizer'])
                            <i class="fa-solid fa-user"></i>{{ $attendee['login'] }}
                        @else
                            <i class="fa-regular fa-user"></i>{{ $attendee['login'] }}
                        @endif
                         @if ($attendee['has_paid'])
                            <i class="fa-solid fa-euro"></i>
                         @endif
                    </a>
                    <div class="attendee-manage-buttons">
                        <form method="POST" action="{{ route('event.attendees.set.payment.status', $event->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="user_id" value="{{ $attendee['id'] }}">
                            <input type="hidden" name="has_paid" value="{{ $attendee['has_paid'] ? 0 : 1 }}">
                            <button type="submit" class="light-button chip">
                                @if ($attendee['has_paid'])
                                    <i class="fa-brands fa-creative-commons-nc-eu"></i>
                                @else
                                    <i class="fa-solid fa-euro"></i>
                                @endif
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
</main>

@if(auth()->user())
<dialog id="demoteSelfModal">
    @include('components.modals.demoteSelf')
</dialog>

<dialog id="promoteOrgaModal">
    @include('components.modals.promoteOrga')
</dialog>
@endif
@include('components.scripts.demoteSelf')
@include('components.scripts.promoteOrga')
<div class="h-70vh"></div>
</x-layoutDoom>
