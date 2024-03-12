<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location_id',
        'price',
        'image_path',
        'max_attendees',
        'file_path',
        'server_link',
        'tickets_link',
        'is_cancelled',
    ];

    protected $with = [
        'location',
    ];


    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class, 'event_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'attendees', 'event_id', 'user_id');
    }

    public function getAttendeesCount()
    {
        return $this->attendees()->count();
    }

    public function organizers()
    {
        return $this->attendees()->where('is_organizer', true);
    }

    public function getOrganizersCount()
    {
        return $this->organizers()->count();
    }

    public function getOrganizersLogin()
    {
        return $this->organizers->map(function ($organizer) {
            return $organizer->user->login;
        })->implode(', ');
    }

    public function getOrganizerLogin($organizer)
    {
        return $organizer->user->login;
    }

    public function checkIfAuthIsOrganizer()
    {
        return $this->organizers()->where('user_id', auth()->id())->exists();
    }

    public function getNonOrganizersAttendeesLogin()
    {
        return $this->attendees()->where('is_organizer', false)->get()->map(function ($attendee) {
            return $attendee->user->login;
        })->implode(', ');
    }

    public function getNonOrganizersLoginAndIdInArray()
    {
        return $this->attendees()->where('is_organizer', false)->get()->map(function ($attendee) {
            return ['login' => $attendee->user->login, 'id' => $attendee->user->id];
        });
    }

    public function formatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function cancel()
    {
        $this->update(['is_cancelled' => true]);
    }

    public function uncancel()
    {
        $this->update(['is_cancelled' => false]);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where('title', 'like', '%' . $search . '%');
        });
    }
}
