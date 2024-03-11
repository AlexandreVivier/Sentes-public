<x-layoutDark>

    <section>
            @include('components.eventCard', ['event' => $event, 'attendees' => $attendees, 'organizers' => $organizers, 'location' => $location])
    </section>

</x-layoutDark>
