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
        @foreach ($event->getSubscribedAttendeesInfos() as $attendee)
                @if ($attendee->is_organizer)
                <li x-data="{ show: false }" @click.away="show = false">
                    <div class="attendee-manage">
                        <p @click="show = !show" class="text-green special-elite-regular event-link link none semi-bold">
                            <i class="fa-solid fa-user"></i>{{ $attendee->user->login }}
                            @if ($attendee->has_paid)
                                <i class="fa-solid fa-euro"></i>
                            @endif
                            @if ($attendee->in_choir)
                                <i class="fa-solid fa-music"></i>
                            @endif
                            @if ($attendee->user->first_aid_qualifications)
                                <i class="fa-solid fa-briefcase-medical"></i>
                            @endif
                        </p>

                        <div class="attendee-manage-buttons">
                            @if ($attendee->user_id === auth()->user()->id)
                                <button type="submit" class="light-button chip" id="demoteSelf"><i class="fa-regular fa-user"></i></button>
                            @endif
                            <form method="POST" action="{{ route('event.attendees.set.payment.status', $event->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id" value="{{ $attendee->user_id }}">
                                <input type="hidden" name="has_paid" value="{{ $attendee->has_paid ? 0 : 1 }}">
                                <button type="submit" class="light-button chip">
                                    @if ($attendee->has_paid)
                                        <i class="fa-brands fa-creative-commons-nc-eu"></i>
                                    @else
                                        <i class="fa-solid fa-euro"></i>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    <div x-show="show" class="attendee-manage-infos">
                            <a href="{{ route('profile.show', $attendee->user->id) }}" class="transparent-button special-elite-regular">Voir le profil</a>
                            <p class="text-green text-normal semi-bold none">Nom complet :
                                <span class="italic normal-weight">{{ $attendee->user->first_name }} {{ $attendee->user->last_name }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Pronoms :
                                <span class="italic normal-weight">{{ isset($attendee->user->pronouns)? $attendee->user->pronouns : 'Non renseignés' }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Téléphone :
                                <span class="italic normal-weight">{{ isset($attendee->user->phone_number) ? $attendee->user->phone_number : 'Non renseigné' }}</span>
                            </p>
                            @if ($attendee->user->first_aid_qualifications)
                            <p class="text-green text-normal semi-bold none">
                                Qualifications de secourisme :
                                <span class="italic normal-weight">{{ $attendee->user->first_aid_qualifications }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->emergency_contact_name)
                            <p class="text-green text-normal semi-bold none">
                                Contact d'urgence :
                                <span class="italic normal-weight">{{ $attendee->user->emergency_contact_name }} au {{ $attendee->user->emergency_contact_phone_number }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->allergies)
                            <p class="text-green text-normal semi-bold none">
                                Allergies :
                                <span class="italic normal-weight">{{ $attendee->user->allergies }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->medical_conditions)
                            <p class="text-green text-normal semi-bold none">
                                Conditions médicales :
                                <span class="italic normal-weight">{{ $attendee->user->medical_conditions }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->diet_restrictions)
                            <p class="text-green text-normal semi-bold none">
                                Restrictions alimentaires :
                                <span class="italic normal-weight">{{ $attendee->user->diet_restrictions }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->red_flag_people)
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de personnes :
                                <span class="italic normal-weight">{{ $attendee->user->red_flag_people }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->trigger_warnings)
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de sujets :
                                <span class="italic normal-weight">{{ $attendee->user->trigger_warnings }}</span>
                            </p>
                            @endif
                    </div>
                </li>
                @else

                <li x-data="{ show: false }" @click.away="show = false">
                    <div class="attendee-manage">
                        <p @click="show = !show" class="text-green special-elite-regular event-link link none">
                            <i class="fa-regular fa-user"></i>{{ $attendee->user->login }}
                            @if ($attendee->has_paid)
                                <i class="fa-solid fa-euro"></i>
                            @endif
                            @if ($attendee->in_choir)
                                <i class="fa-solid fa-music"></i>
                            @endif
                            @if ($attendee->user->first_aid_qualifications)
                                <i class="fa-solid fa-briefcase-medical"></i>
                            @endif
                        </p>

                        <div class="attendee-manage-buttons">
                            <button class="light-button chip" id="promoteOrga-{{ $attendee->id }}">
                                <i class="fa-solid fa-user"></i>
                            </button>
                            <form method="POST" action="{{ route('event.attendees.set.payment.status', $event->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="user_id" value="{{ $attendee->id }}">
                                <input type="hidden" name="has_paid" value="{{ $attendee->has_paid ? 0 : 1 }}">
                                <button type="submit" class="light-button chip">
                                    @if ($attendee->has_paid)
                                        <i class="fa-brands fa-creative-commons-nc-eu"></i>
                                    @else
                                        <i class="fa-solid fa-euro"></i>
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>
                    <div x-show="show" class="attendee-manage-infos">
                            <a href="{{ route('profile.show', $attendee->user_id) }}" class="transparent-button special-elite-regular">Voir le profil</a>
                            <p class="text-green text-normal semi-bold none">Nom complet :
                                <span class="italic normal-weight">{{ $attendee->user->first_name }} {{ $attendee->user->last_name }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Pronoms :
                                <span class="italic normal-weight">{{ isset($attendee->user->pronouns)? $attendee->user->pronouns : 'Non renseignés' }}</span>
                            </p>
                            <p class="text-green text-normal semi-bold none">
                                Téléphone :
                                <span class="italic normal-weight">{{ isset($attendee->user->phone_number) ? $attendee->user->phone_number : 'Non renseigné' }}</span>
                            </p>
                            @if ($attendee->user->first_aid_qualifications)
                            <p class="text-green text-normal semi-bold none">
                                Qualifications de secourisme :
                                <span class="italic normal-weight">{{ $attendee->user->first_aid_qualifications }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->emergency_contact_name)
                            <p class="text-green text-normal semi-bold none">
                                Contact d'urgence :
                                <span class="italic normal-weight">{{ $attendee->user->emergency_contact_name }} au {{ $attendee->user->emergency_contact_phone_number }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->allergies)
                            <p class="text-green text-normal semi-bold none">
                                Allergies :
                                <span class="italic normal-weight">{{ $attendee->user->allergies }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->medical_conditions)
                            <p class="text-green text-normal semi-bold none">
                                Conditions médicales :
                                <span class="italic normal-weight">{{ $attendee->user->medical_conditions }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->diet_restrictions)
                            <p class="text-green text-normal semi-bold none">
                                Restrictions alimentaires :
                                <span class="italic normal-weight">{{ $attendee->user->diet_restrictions }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->red_flag_people)
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de personnes :
                                <span class="italic normal-weight">{{ $attendee->user->red_flag_people }}</span>
                            </p>
                            @endif
                            @if ($attendee->user->trigger_warnings)
                            <p class="text-green text-normal semi-bold none">
                                Restrictions de sujets :
                                <span class="italic normal-weight">{{ $attendee->user->trigger_warnings }}</span>
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
            @foreach ($event->getUnsubscribedAttendeesInfos() as $attendee)
                <li class="attendee-manage">
                    <a href=" {{ route('profile.show', $attendee->user->id) }}" class="text-light-green special-elite-regular event-link italic link none">
                        @if ($attendee->is_organizer)
                            <i class="fa-solid fa-user"></i>{{ $attendee->user->login }}
                        @else
                            <i class="fa-regular fa-user"></i>{{ $attendee->user->login }}
                        @endif
                         @if ($attendee->has_paid)
                            <i class="fa-solid fa-euro"></i>
                         @endif
                    </a>
                    <div class="attendee-manage-buttons">
                        <form method="POST" action="{{ route('event.attendees.set.payment.status', $event->id) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="user_id" value="{{ $attendee->id }}">
                            <input type="hidden" name="has_paid" value="{{ $attendee->has_paid ? 0 : 1 }}">
                            <button type="submit" class="light-button chip">
                                @if ($attendee->has_paid)
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

@foreach($attendees as $attendee)
    <dialog id="promoteOrgaModal-{{ $attendee->id }}">
        @include('components.modals.promoteOrga', ['attendee' => $attendee])
    </dialog>
@endforeach
@endif
@include('components.scripts.demoteSelf')
@include('components.scripts.promoteOrga', ['attendee' => $attendee])
<div class="h-70vh"></div>
</x-layoutDoom>
