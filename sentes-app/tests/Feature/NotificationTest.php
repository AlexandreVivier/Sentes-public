<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Event;
use App\Models\Location;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function NewEvent_notification_sent()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);


        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');

        $this->createOrganizerWithLocationAndEvent();

        $organizer = User::where('login', 'organizer')->first();
        $this->actingAs($organizer);

        // Check DB :
        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEvent',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEvent',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        // Check Front coté orga :
        $this->get(route('notifications.index'))
            ->assertDontSee('Pas de notifications pour le moment.')
            ->assertSee('Un nouvel événement est organisé sur les Sentes !');

        // Check Front coté user :
        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session

        $this->actingAs($user);

        $this->get(route('notifications.index'))
            ->assertDontSee('Pas de notifications pour le moment.')
            ->assertSee('Un nouvel événement est organisé sur les Sentes !');
    }

    /** @test */
    public function EventUpdated_notification_sent()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);


        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');

        $this->createOrganizerWithLocationAndEvent();

        $organizer = User::where('login', 'organizer')->first();
        $this->actingAs($organizer);

        $event = Event::where('title', 'Test event')->first();

        // As $organizer, update the event
        $this->patch(route('event.modify', $event->id), [
            'title' => 'Test event updated',
            'description' => 'This is a test event updated',
            'start_date' => now()->addDay(),
            'location_id' => $event->location_id,
            'max_attendees' => 2,
        ])->assertRedirect(route('events.show', $event->id))
            ->assertStatus(302);

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session

        $this->actingAs($user);

        // inscrire l'user au GN :
        $this->post(route('attendee.subscribe', $event->id))
            ->assertRedirect(route('events.show', $event->id))
            ->assertStatus(302);

        // Créer un user non inscrit au GN:
        $stranger = User::factory()->create([
            'login' => 'stranger',
        ]);

        // refaire une modification du GN côté orga :

        $this->actingAs($organizer);

        $this->patch(route('event.modify', $event->id), [
            'title' => 'Test event updated',
            'description' => 'This is a test event updated',
            'start_date' => now()->addDay(),
            'location_id' => $event->location_id,
            'max_attendees' => 3,
        ]);

        // Check DB :

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\EventUpdated',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\EventUpdated',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseMissing('notifications', [
            'type' => 'App\Notifications\EventUpdated',
            'notifiable_id' => $stranger->id,
            'notifiable_type' => 'App\Models\User',
        ]);
    }

    /** @test */
    public function EventCancelled_notification_sent()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');

        $this->createOrganizerWithLocationAndEvent();

        // inscrire un $user au GN :

        $user = User::where('login', 'user')->first();
        $this->actingAs($user);

        $event = Event::where('title', 'Test event')->first();

        $this->post(route('attendee.subscribe', $event->id))
            ->assertRedirect(route('events.show', $event->id))
            ->assertStatus(302);

        // créer un user $stranger non inscrit au GN :

        $stranger = User::factory()->create([
            'login' => 'stranger',
        ]);

        // As $organizer, cancel the event

        $organizer = User::where('login', 'organizer')->first();
        $this->actingAs($organizer);

        $this->patch(route('event.modify', $event->id), [
            'title' => 'Test event updated',
            'description' => 'This is a test event updated',
            'start_date' => now()->addDay(),
            'location_id' => $event->location_id,
            'is_cancelled' => true,
        ]);

        // vérif notif orga coté front :
        $this->get(route('notifications.index'))
            ->assertSee('Ton GN a été annulé !');

        // vérif notif user coté front :

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session

        $this->actingAs($user);

        $this->get(route('notifications.index'))
            ->assertSee('Ton GN a été annulé !');

        // vérif notif stranger coté front :

        $stranger = User::find($stranger->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($stranger);

        $this->get(route('notifications.index'))
            ->assertDontSee('Ton GN a été annulé !');


        // Check DB :

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\EventCancelled',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\EventCancelled',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseMissing('notifications', [
            'type' => 'App\Notifications\EventCancelled',
            'notifiable_id' => $stranger->id,
            'notifiable_type' => 'App\Models\User',
        ]);
    }

    /** @test */
    public function NewEventSubscriber_Unsubscribe_notifications_for_orga()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');

        $this->createOrganizerWithLocationAndEvent();

        // inscrire un $user au GN :

        $user = User::where('login', 'user')->first();
        $this->actingAs($user);

        $event = Event::where('title', 'Test event')->first();

        $this->post(route('attendee.subscribe', $event->id));

        // vérifier en front que l'user n'est pas notifié :
        $this->get(route('notifications.index'))
            ->assertDontSee('Nouvelle inscription sur ton GN !');

        // Revenir en Orga et vérifier les notifs coté front :

        $organizer = User::where('login', 'organizer')->first();
        $this->actingAs($organizer);

        $this->get(route('notifications.index'))
            ->assertSee('Nouvelle inscription sur ton GN !');

        // Check DB :

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEventSubscriber',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseMissing('notifications', [
            'type' => 'App\Notifications\NewEventSubscriber',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        // Se désinscrire du GN :

        $this->actingAs($user);

        $this->delete(route('attendee.unsubscribe', $event->id));

        // Check DB :

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEventUnsubscribe',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        // check front pour orga :
        $organizer = User::find($organizer->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($organizer);

        $this->get(route('notifications.index'))
            ->assertSee('Désistement sur ton GN !');
    }

    /** @test */
    public function OrgaPromote_Downgrade_notifications_for_orgas()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');

        $this->createOrganizerWithLocationAndEvent();

        // inscrire un $user au GN :

        $user = User::where('login', 'user')->first();
        $this->actingAs($user);

        $event = Event::where('title', 'Test event')->first();

        $this->post(route('attendee.subscribe', $event->id));

        // Se connecter en orga et promouvoir un user en orga :

        $organizer = User::where('login', 'organizer')->first();

        $attendeeId = DB::table('attendees')
            ->where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->where('is_subscribed', true)->first()->id;

        $this->actingAs($organizer);

        $this->patch(route('event.attendees.promote', [$event->id, $attendeeId]));

        // check coté front orga pour la notif :
        $this->get(route('notifications.index'))
            ->assertSee('Cet utilisateur est maintenant organisateur·rice de l\'événement !');

        // check DB :

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\OrgaPromotion',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\OrgaPromotion',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        // Se connecter en user et se rétrograder :

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);

        $this->patch(route('event.organizer.demote.self', $event->id));

        // check coté front orga pour la notif :

        $organizer = User::find($organizer->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($organizer);

        $this->get(route('notifications.index'))
            ->assertSee('Départ de l\'orga !');

        // check DB :

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\OrgaDowngrade',
            'notifiable_id' => $organizer->id,
            'notifiable_type' => 'App\Models\User',
        ]);
    }

    /** @test */
    public function delete_all_notifications()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        $this->createOrganizerWithLocationAndEvent();

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEvent',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);

        $this->get(route('notifications.deleteAll'));

        // dd(auth()->user()->id);
        $this->assertDatabaseMissing('notifications', [
            'type' => 'App\Notifications\NewEvent',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
        ]);
    }

    /** @test */
    public function clicked_notification_is_marked_as_read_and_redirect()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        $this->createOrganizerWithLocationAndEvent();

        $notification = DB::table('notifications')->where('notifiable_id', $user->id)->first();

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);

        $this->get(route('notifications.show', $notification->id))
            ->assertRedirect(route('events.show', Event::where('title', 'Test event')->first()->id));

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'read_at' => now(),
        ]);
    }

    /** @test */
    public function delete_a_specific_notification()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        $this->createOrganizerWithLocationAndEvent();

        $notification = DB::table('notifications')->where('notifiable_id', $user->id)->first();

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);

        $this->get(route('notifications.delete', $notification->id));

        $this->assertDatabaseMissing('notifications', [
            'id' => $notification->id,
        ]);
    }

    /** @test */
    public function read_all_notifications()
    {
        $user = User::factory()->create([
            'login' => 'user',
        ]);
        $this->actingAs($user);

        $this->createOrganizerWithLocationAndEvent();

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEvent',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
            'read_at' => null,
        ]);

        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);

        $this->get(route('notifications.markAllAsRead'));

        $this->assertDatabaseHas('notifications', [
            'type' => 'App\Notifications\NewEvent',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
            'read_at' => now(),
        ]);
    }
}
