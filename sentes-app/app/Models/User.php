<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'login',
        'email',
        'password',
        'avatar_path',
        'city',
        'accepted_terms',
        'is_admin',
        'is_banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_banned' => 'boolean'
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class, 'user_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'author_id');
    }

    public function myParticipations()
    {
        return $this->hasMany(Attendee::class, 'user_id');
    }

    public function myOrganisations()
    {
        return $this->hasMany(Attendee::class, 'user_id')->where('is_organizer', true);
    }

    public function myProjects()
    {
        return $this->hasMany(Event::class, 'author_id');
    }
}
