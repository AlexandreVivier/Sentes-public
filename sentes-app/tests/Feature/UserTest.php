<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function visitor_can_register_with_valid_credentials()
    {
        $this->get(route('register'))
            ->assertStatus(200);

        $this->post(route('register'), [
            'login' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'mail@mail.com',
            'password' => 'SuperP@ssword1!',
            'password_confirmation' => 'SuperP@ssword1!',
            'accepted_terms' => true,
        ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('success', 'Ton compte a bien été créé ! Vérifie ta boîte mail pour activer ton compte !');

        $this->assertDatabaseHas('users', [
            'login' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'mail@mail.com',
        ]);

        // Invalid user email :
        $this->post(route('logout'));
        $this->post(route('register'), [
            'login' => 'James Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'pouet',
            'password' => 'SuperP@ssword1!',
            'password_confirmation' => 'SuperP@ssword1!',
            'accepted_terms' => true,
        ])
            ->assertSessionHasErrors('email');

        // Invalid password regex user :
        $this->post(route('logout'));
        $this->post(route('register'), [
            'login' => 'James Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'amail@mail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'accepted_terms' => true,
        ])
            ->assertSessionHasErrors('password');

        // User already exists :

        $this->post(route('logout'));

        $this->post(route('register'), [
            'login' => 'John Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'mail@mail.com',
            'password' => 'SuperP@ssword1!',
            'password_confirmation' => 'SuperP@ssword1!',
            'accepted_terms' => true,
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['login', 'email']);

        // Invalid accepted terms :
        $this->post(route('logout'));
        $this->post(route('register'), [
            'login' => 'Jane Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'mail2@mail.com',
            'password' => 'SuperP@ssword1!',
            'password_confirmation' => 'SuperP@ssword1!',
            'accepted_terms' => 0,
        ]);

        $this->assertDatabaseMissing('users', [
            'login' => 'Jane Doe',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }
}
