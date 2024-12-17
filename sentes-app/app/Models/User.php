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

    public function archetypes()
    {
        return $this->hasMany(Archetype::class, 'author_id');
    }

    public function archetypeLists()
    {
        return $this->hasMany(ArchetypeList::class, 'author_id');
    }

    public function archetypeCategories()
    {
        return $this->hasMany(ArchetypeCategory::class, 'author_id');
    }

    public function rituals()
    {
        return $this->hasMany(Ritual::class, 'author_id');
    }

    public function ritualLists()
    {
        return $this->hasMany(RitualList::class, 'author_id');
    }

    public function communities()
    {
        return $this->hasMany(Community::class, 'author_id');
    }

    public function communityLists()
    {
        return $this->hasMany(CommunityList::class, 'author_id');
    }

    public function backgrounds()
    {
        return $this->hasMany(Background::class, 'author_id');
    }

    public function backgroundLists()
    {
        return $this->hasMany(BackgroundList::class, 'author_id');
    }

    public function miscellaneousCategories()
    {
        return $this->hasMany(MiscellaneousCategory::class, 'author_id');
    }

    public function miscellaneousLists()
    {
        return $this->hasMany(MiscellaneousList::class, 'author_id');
    }

    public function miscellaneous()
    {
        return $this->hasMany(Miscellaneous::class, 'author_id');
    }

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
