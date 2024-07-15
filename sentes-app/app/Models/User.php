<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'first_name',
    //     'last_name',
    //     'login',
    //     'email',
    //     'password',
    //     'avatar_path',
    //     'city',
    //     'accepted_terms',
    //     'is_admin',
    //     'is_banned'
    // ];

    protected $guarded = [];
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
        // 'password' => 'hashed',
        'is_admin' => 'boolean',
        'is_banned' => 'boolean'
    ];

    protected function formatDate($date)
    {
        return Carbon::parse($date)->isoFormat('Do MMM YYYY');
    }

    public function getFormatedDate($value)
    {
        return $this->formatDate($value);
    }

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

    public function allEvents()
    {
        return $this->hasManyThrough(Event::class, Attendee::class, 'user_id', 'id', 'id', 'event_id');
    }

    public function getAllFutureEvents()
    {
        return $this->allEvents()->where('start_date', '>', now())->where('is_cancelled', false)->get();
    }


    public function isOrganiser()
    {
        return $this->hasMany(Attendee::class, 'user_id')->where('is_organizer', true);
    }

    public function getAllFutureEventsOrganizedByUser()
    {
        return $this->hasManyThrough(Event::class, Attendee::class, 'user_id', 'id', 'id', 'event_id')->where('is_organizer', true)->get();
    }
}
