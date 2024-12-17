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

    // protected $fillable = [
    //     'title',
    //     'description',
    //     'start_date',
    //     'end_date',
    //     'location_id',
    //     'price',
    //     'image_path',
    //     'max_attendees',
    //     'file_path',
    //     'server_link',
    //     'tickets_link',
    //     'is_cancelled',
    //     'photos_link',
    //     'video_link',
    //     'retex_form_link',
    //     'retex_document_path',
    // ];

    protected $guarded = [];

    protected $with = [
        'location',
        'attendees',
        // 'archetypesLists',
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

    public function contents()
    {
        return $this->hasMany(Content::class, 'event_id');
    }

    public function getAttendeesCount()
    {
        return $this->attendees()->where('is_subscribed', true)->count();
    }

    public function organizers()
    {
        return $this->attendees()->where('is_organizer', true)->where('is_subscribed', true);
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

    public function checkAuthAttendeeStatus()
    {
        $auth = $this->attendees()->where('user_id', auth()->id())->first();
        switch ($auth) {
            case null:
                return 'null';
                break;
            case $auth->is_organizer:
                return 'organizer';
                break;
            case $auth->is_subscribed:
                return 'subscribed';
                break;
            case !$auth->is_subscribed:
                return 'unsubscribed';
                break;
            default:
                return 'error';
        }
    }

    public function checkIfAuthIsOrganizerOrAdmin()
    {
        $attendee = $this->attendees()->where('user_id', auth()->id())->first();
        if ($attendee === null) {
            return false;
        }
        if ($attendee->is_organizer || auth()->user()->is_admin) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrganizersDataInArray()
    {
        $attendees = $this->organizers;
        $attendeesId = $attendees->pluck('user_id');
        $users = User::whereIn('id', $attendeesId)->get();
        $users = $users->map(function ($user) use ($attendees) {
            $attendee = $attendees->where('user_id', $user->id)->first();
            return [
                'login' => $user->login,
                'id' => $user->id,
                'has_paid' => $attendee->has_paid,
            ];
        });
        return $users;
    }

    public function getNonOrganizersDataInArray()
    {
        $attendees = $this->attendees()->where('is_subscribed', true)->where('is_organizer', false)->get();
        $attendeesId = $attendees->pluck('user_id');
        $users = User::whereIn('id', $attendeesId)->get();
        $users = $users->map(function ($user) use ($attendees) {
            $attendee = $attendees->where('user_id', $user->id)->first();
            return [
                'login' => $user->login,
                'id' => $user->id,
                'has_paid' => $attendee->has_paid,
            ];
        });
        return $users;
    }

    public function getUnsubscribedAttendeesDataInArray()
    {
        $attendees = $this->attendees()->where('is_subscribed', false)->get();
        $attendeesId = $attendees->pluck('user_id');
        $users = User::whereIn('id', $attendeesId)->get();
        $users = $users->map(function ($user) use ($attendees) {
            $attendee = $attendees->where('user_id', $user->id)->first();
            return [
                'login' => $user->login,
                'id' => $user->id,
                'has_paid' => $attendee->has_paid,
            ];
        });
        return $users;
    }

    public function getSubscribedAttendeesInfos()
    {
        return $this->attendees()->where('is_subscribed', true)->get();
    }

    public function getUnsubscribedAttendeesInfos()
    {
        return $this->attendees()->where('is_subscribed', false)->get();
    }

    public function getUnsubscribedAttendeesCount()
    {
        return $this->attendees()->where('is_subscribed', false)->count();
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
