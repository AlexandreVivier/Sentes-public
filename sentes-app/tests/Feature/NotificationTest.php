<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Event;
use App\Models\Location;
use App\Models\Attendee;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function NewEvent_notification_sent()
    {
        // Simuler les queues et créer l'event :
        Notification::fake();
        $user = User::factory()->create([
            'login' => 'userNot1',
        ]);
        $this->actingAs($user);
        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
        $this->createOrganizerWithLocationAndEvent('notif NewEvent', 'notif1');
        Event::where('title', 'Test event notif NewEvent')->first();
        $organizer = User::where('login', 'organizerNotif1')->first();
        Notification::assertSentTo(
            $organizer,
            \App\Notifications\NewEvent::class
        );
        Notification::assertSentTo(
            $user,
            \App\Notifications\NewEvent::class
        );
        // Notification::assertNothingSent();
        // Notification::fake(false); // Pour que les notifications soient sauvegardées.

        // Check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\NewEvent',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\NewEvent',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $organizer = User::find($organizer->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($organizer);
        // // // Check Front coté orga :
        // $this->get(route('notifications.index'))
        //     ->assertDontSee('Pas de notifications pour le moment.')
        //     ->assertSee('Un nouvel événement est organisé sur les Sentes !');
        // // Check Front coté user :
        // $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($user);
        // $this->get(route('notifications.index'))
        //     ->assertDontSee('Pas de notifications pour le moment.')
        //     ->assertSee('Un nouvel événement est organisé sur les Sentes !');
    }

    /** @test */
    public function EventUpdated_notification_sent()
    {
        Notification::fake();
        $user = User::factory()->create([
            'login' => 'userNot2',
        ]);
        $this->actingAs($user);
        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
        $this->createOrganizerWithLocationAndEvent('notif EventUpdated', 'notif2');
        // Créer un orga et se log
        $organizer = User::where('login', 'organizerNotif2')->first();
        $this->actingAs($organizer);
        $event = Event::where('title', 'Test event notif EventUpdated')->first();

        // As $organizer, update the event
        $this->patch(route('event.modify', $event->id), [
            'title' => 'Test event updated',
            'description' => 'This is a test event updated',
            'start_date' => $event->start_date,
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
            'login' => 'strangerNot1',
        ]);
        // refaire une modification du GN côté orga :
        $this->actingAs($organizer);
        $this->patch(route('event.modify', $event->id), [
            'title' => 'Test event updated',
            'description' => 'This is a test event updated',
            'start_date' => $event->start_date,
            'location_id' => $event->location_id,
            'max_attendees' => 3,
        ]);
        Notification::assertSentTo(
            $organizer,
            \App\Notifications\EventUpdated::class
        );
        Notification::assertSentTo(
            $user,
            \App\Notifications\EventUpdated::class
        );
        Notification::assertNotSentTo(
            $stranger,
            \App\Notifications\EventUpdated::class
        );

        // vérif notif coté front :
        // $this->get(route('notifications.index'))
        //     ->assertSee('Ton GN a été mis à jour !');
        // $this->actingAs($user);
        // $this->get(route('notifications.index'))
        //     ->assertSee('Ton GN a été mis à jour !');
        // $this->actingAs($stranger);
        // $this->get(route('notifications.index'))
        //     ->assertDontSee('Ton GN a été mis à jour !');
        // // Check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\EventUpdated',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\EventUpdated',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseMissing('notifications', [
        //     'type' => 'App\Notifications\EventUpdated',
        //     'notifiable_id' => $stranger->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
    }

    /** @test */
    public function EventCancelled_notification_sent()
    {
        Notification::fake();
        $user = User::factory()->create([
            'login' => 'userNotif3',
        ]);
        $this->actingAs($user);
        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
        $this->createOrganizerWithLocationAndEvent('notif EventCancelled', 'notif3');
        // Créer un orga et se log
        $organizer = User::where('login', 'organizerNotif3')->first();
        $this->actingAs($organizer);
        $event = Event::where('title', 'Test event notif EventCancelled')->first();
        $this->patch(route('events.update', $event->id), [
            'title' => 'Test notif 3',
            'description' => 'This is a test event',
            'start_date' => $event->start_date,
            'location_id' => $event->location_id,
            'max_attendees' => 3,
        ]);
        // inscrire un $user au GN :
        $user = User::where('login', 'userNotif3')->first();
        $this->actingAs($user);
        $this->post(route('attendee.subscribe', $event->id))
            ->assertRedirect(route('events.show', $event->id))
            ->assertStatus(302);
        // créer un user $stranger non inscrit au GN :
        $stranger = User::factory()->create([
            'login' => 'stranger',
        ]);
        // As $organizer, cancel the event
        $this->actingAs($organizer);
        $this->patch(route('event.modify', $event->id), [
            'title' => 'Test event Cancelled',
            'description' => 'This is a test event cancelled',
            'start_date' => $event->start_date,
            'location_id' => $event->location_id,
            'is_cancelled' => true,
        ]);
        Notification::assertSentTo(
            $organizer,
            \App\Notifications\EventCancelled::class
        );
        Notification::assertSentTo(
            $user,
            \App\Notifications\EventCancelled::class
        );
        Notification::assertNotSentTo(
            $stranger,
            \App\Notifications\EventCancelled::class
        );
        // // vérif notif orga coté front :
        // $this->get(route('notifications.index'))
        //     ->assertSee('Ton GN a été annulé !');
        // // vérif notif user coté front :
        // $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($user);
        // $this->get(route('notifications.index'))
        //     ->assertSee('Ton GN a été annulé !');
        // // vérif notif stranger coté front :
        // $stranger = User::find($stranger->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($stranger);
        // $this->get(route('notifications.index'))
        //     ->assertDontSee('Ton GN a été annulé !');
        // // Check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\EventCancelled',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\EventCancelled',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseMissing('notifications', [
        //     'type' => 'App\Notifications\EventCancelled',
        //     'notifiable_id' => $stranger->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
    }

    /** @test */
    public function NewEventSubscriber_Unsubscribe_notifications_for_orga()
    {
        Notification::fake();
        $user = User::factory()->create([
            'login' => 'userNotif4',
        ]);
        $this->actingAs($user);
        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
        $this->createOrganizerWithLocationAndEvent('notif NewEventSubscriber', 'notif4');
        $event = Event::where('title', 'Test event notif NewEventSubscriber')->first();
        $organizer = User::where('login', 'organizernotif4')->first();
        $this->patch(route('events.update', $event->id), [
            'title' => 'Test notif 4',
            'description' => 'This is a test event',
            'start_date' => $event->start_date,
            'location_id' => $event->location_id,
            'max_attendees' => 7,
        ]);
        // inscrire un $user au GN :
        $this->actingAs($user);
        $this->post(route('attendee.subscribe', $event->id));
        Notification::assertSentTo(
            $organizer,
            \App\Notifications\NewEventSubscriber::class
        );
        Notification::assertNotSentTo(
            $user,
            \App\Notifications\NewEventSubscriber::class
        );
        // vérifier en front que l'user n'est pas notifié :
        // $this->get(route('notifications.index'))
        //     ->assertDontSee('Nouvelle inscription sur ton GN !');
        // // Revenir en Orga et vérifier les notifs coté front :
        // $this->actingAs($organizer);
        // $this->get(route('notifications.index'))
        //     ->assertSee('Nouvelle inscription sur ton GN !');
        // // Check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\NewEventSubscriber',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseMissing('notifications', [
        //     'type' => 'App\Notifications\NewEventSubscriber',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // Se désinscrire du GN :
        $this->actingAs($user);
        $this->delete(route('attendee.unsubscribe', $event->id));
        Notification::assertSentTo(
            $organizer,
            \App\Notifications\NewEventUnsubscribe::class
        );
        Notification::assertNotSentTo(
            $user,
            \App\Notifications\NewEventUnsubscribe::class
        );
        // // check front :
        // $this->get(route('notifications.index'))
        //     ->assertDontSee('Désistement sur ton GN !');
        // $organizer = User::find($organizer->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($organizer);
        // $this->get(route('notifications.index'))
        //     ->assertSee('Désistement sur ton GN !');
        // Check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\NewEventUnsubscribe',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseMissing('notifications', [
        //     'type' => 'App\Notifications\NewEventUnsubscribe',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
    }

    /** @test */
    public function OrgaPromote_Downgrade_notifications_for_orgas()
    {
        Notification::fake();
        $user = User::factory()->create([
            'login' => 'userNotif5',
        ]);
        $this->actingAs($user);
        // Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
        $this->createOrganizerWithLocationAndEvent('notif OrgaPromote', 'notif5');
        $event = Event::where('title', 'Test event notif OrgaPromote')->first();
        $organizer = User::where('login', 'organizernotif5')->first();
        // inscrire un $user au GN :
        $this->actingAs($user);
        $this->post(route('attendee.subscribe', $event->id));
        // Se connecter en orga et promouvoir un user en orga :
        $attendeeId = DB::table('attendees')
            ->where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->where('is_subscribed', true)->first()->id;
        $this->actingAs($organizer);
        $this->patch(route('event.attendees.promote', [$event->id, $attendeeId]));
        Notification::assertSentTo(
            $organizer,
            \App\Notifications\OrgaPromotion::class
        );
        Notification::assertSentTo(
            $user,
            \App\Notifications\OrgaPromotion::class
        );
        // check coté front orga pour la notif :
        // $this->get(route('notifications.index'))
        //     ->assertSee('Nouvel·le orga !');
        // $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($user);
        // $this->get(route('notifications.index'))
        //     ->assertSee('Nouvel·le orga !');
        // check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\OrgaPromotion',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\OrgaPromotion',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        // Se connecter en user et se rétrograder :
        $this->patch(route('event.organizer.demote.self', $event->id));
        Notification::assertNotSentTo(
            $organizer,
            \App\Notifications\OrgaDowngrade::class
        );
        Notification::assertSentTo(
            $user,
            \App\Notifications\OrgaDowngrade::class
        );
        // check coté front orga pour la notif :
        // $organizer = User::find($organizer->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        // $this->actingAs($organizer);
        // $this->get(route('notifications.index'))
        //     ->assertSee('Départ de l\'orga !');
        // check DB :
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\OrgaDowngrade',
        //     'notifiable_id' => $organizer->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
    }

    /** @test */
    public function delete_all_notifications()
    {
        Notification::fake();
        $user = User::factory()->create([
            'login' => 'userNotif6',
        ]);
        $this->actingAs($user);
        //Check Front préalable :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
        $this->createOrganizerWithLocationAndEvent('notif DeleteAll', 'notif6');
        Event::where('title', 'Test event notif DeleteAll')->first();
        Notification::assertSentTo(
            $user,
            \App\Notifications\NewEvent::class
        );
        // $this->assertDatabaseHas('notifications', [
        //     'type' => 'App\Notifications\NewEvent',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);
        $this->get(route('notifications.deleteAll'))
            ->assertSessionDoesntHaveErrors();
        // $this->assertDatabaseMissing('notifications', [
        //     'type' => 'App\Notifications\NewEvent',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        // ]);
        $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
        $this->actingAs($user);
        //Check Front après suppression :
        $this->get(route('notifications.index'))
            ->assertSee('Pas de notifications pour le moment.');
    }

    // /** @test */
    // public function clicked_notification_is_marked_as_read_and_redirect()
    // {
    //     Notification::fake();
    //     $user = User::factory()->create([
    //         'login' => 'userNotif7',
    //     ]);
    //     $this->actingAs($user);
    //     //Check Front préalable :
    //     $this->get(route('notifications.index'))
    //         ->assertSee('Pas de notifications pour le moment.');
    //     $this->createOrganizerWithLocationAndEvent('notif Clicked', 'notif7');
    //     Event::where('title', 'Test event notif Clicked')->first();
    //     $notification = DB::table('notifications')->where('notifiable_id', $user->id)->first();
    //     $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
    //     $this->actingAs($user);
    //     $this->get(route('notifications.show', $notification->id))
    //         ->assertRedirect(route('events.show', Event::where('title', 'Test event notif Clicked')->first()->id));
    //     $this->assertDatabaseHas('notifications', [
    //         'id' => $notification->id,
    //         'read_at' => now(),
    //     ]);
    //     $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
    //     $this->actingAs($user);
    //     //Check Front après redirection :
    //     $this->get(route('notifications.index'))
    //         ->assertSee('Pas de notifications non lues.');
    // }

    // /** @test */
    // public function delete_a_specific_notification()
    // {
    //     $user = User::factory()->create([
    //         'login' => 'userNotif8',
    //     ]);
    //     $this->actingAs($user);
    //     //Check Front préalable :
    //     $this->get(route('notifications.index'))
    //         ->assertSee('Pas de notifications pour le moment.');

    //     $this->createOrganizerWithLocationAndEvent('notif DeleteOne', 'notif8');
    //     Event::where('title', 'Test event notif DeleteOne')->first();
    //     $notification = DB::table('notifications')->where('notifiable_id', $user->id)->first();
    //     $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
    //     $this->actingAs($user);
    //     $this->get(route('notifications.delete', $notification->id));
    //     $this->assertDatabaseMissing('notifications', [
    //         'id' => $notification->id,
    //     ]);
    //     $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
    //     $this->actingAs($user);
    //     //Check Front après suppression :
    //     $this->get(route('notifications.index'))
    //         ->assertSee('Pas de notifications pour le moment.');
    // }

    // /** @test */
    // public function read_all_notifications()
    // {
    //     $user = User::factory()->create([
    //         'login' => 'userNotif9',
    //     ]);
    //     $this->actingAs($user);
    //     // Check Front préalable :
    //     $this->get(route('notifications.index'))
    //         ->assertSee('Pas de notifications pour le moment.');
    //     $this->createOrganizerWithLocationAndEvent('notif ReadAll', 'notif9');
    //     Event::where('title', 'Test event notif ReadAll')->first();
    //     $this->assertDatabaseHas('notifications', [
    //         'type' => 'App\Notifications\NewEvent',
    //         'notifiable_id' => $user->id,
    //         'notifiable_type' => 'App\Models\User',
    //         'read_at' => null,
    //     ]);

    //     $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
    //     $this->actingAs($user);
    //     $this->get(route('notifications.markAllAsRead'));
    //     $this->assertDatabaseHas('notifications', [
    //         'type' => 'App\Notifications\NewEvent',
    //         'notifiable_id' => $user->id,
    //         'notifiable_type' => 'App\Models\User',
    //         'read_at' => now(),
    //     ]);
    //     $user = User::find($user->id); // Recharge l'utilisateur depuis la base de données pour recréer une session
    //     $this->actingAs($user);
    //     // Check Front après marquage comme lu :
    //     $this->get(route('notifications.index'))
    //         ->assertSee('Pas de notifications non lues.');
    // }
}
